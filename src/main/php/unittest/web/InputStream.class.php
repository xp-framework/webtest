<?php namespace unittest\web;

class InputStream extends \lang\Object implements \io\streams\InputStream {
  const META_TAG = '<meta http-equiv="content-type" content="text/html; charset=%s">';

  private $in, $head;

  /**
   * Creates a new input stream
   *
   * @param  peer.http.HttpResponse $response
   */
  public function __construct($response) {
    $this->in= $response->getInputStream();

    $charset= 'iso-8859-1'; // HTTP defines this as default!
    if ($header= $response->header('Content-Type')) {
      sscanf($header[0], '%[^;]; charset=%s', $contentType, $charset);
    }
    $this->embed($charset);
  }

  /**
   * Embeds charset in head-section so that LibXML can pick it up during
   * parsing. Unfortunately there is no way to tell DomDocument::loadHTML
   * which charset the content is in other than this workaround.
   *
   * @param  string $charset
   * @return void
   */
  private function embed($charset) {
    $this->head= '';
    while ($this->in->available()) {
      $this->head.= $this->in->read();

      if (preg_match('#\<meta\s+charset\s*=(.+)\>#i', $this->head, $matches)) {
        $this->head= str_replace($matches[0], sprintf(self::META_TAG, trim($matches[1], ' "\'')), $this->head);
        return;
      } else if (preg_match('#\<(/head|body)\>#i', $this->head, $matches)) {
        $this->head= str_replace($matches[0], sprintf(self::META_TAG, $charset).$matches[0], $this->head);
        return;
      }
    }
  }

  /**
   * Read a string
   *
   * @param   int limit default 8192
   * @return  string
   */
  public function read($limit= 8192) {
    if ($this->head) {
      $chunk= substr($this->head, 0, $limit);
      $this->head= substr($this->head, $limit);
      return $chunk;
    } else {
      return $this->in->read($limit);
    }
  }

  /**
   * Returns the number of bytes that can be read from this stream 
   * without blocking.
   *
   * @return int
   */
  public function available() {
    return $this->head || $this->in->available();
  }

  /**
   * Closes this input stream
   *
   * @return void
   */
  public function close() {
    $this->in->close();
  }
}