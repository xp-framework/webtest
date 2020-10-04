<?php namespace unittest\web\tests;

use io\streams\MemoryInputStream;
use peer\http\{HttpConnection, HttpConstants, HttpResponse};
use unittest\TestCase;

abstract class WebTestCaseTest extends TestCase {
  protected $fixture= null;

  /** @return void */
  public function setUp() {
    $this->fixture= newinstance('#[Webtest(url: "http://localhost/")] unittest.web.WebTestCase', [$this->name], [
      'response' => null,
      'doRequest' => function($method, $params) {
        return $this->response;
      },
      'respondWith' => function($status, $headers= [], $body= '') {
        $headers[]= 'Content-Length: '.strlen($body);
        $this->response= new HttpResponse(new MemoryInputStream(sprintf(
          "HTTP/1.0 %d Message\r\n%s\r\n\r\n%s",
          $status,
          implode("\r\n", $headers),
          $body
        )));
      }
    ]);
  }
}