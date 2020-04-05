<?php namespace unittest\web;

use lang\FormatException;

/**
 * Represents a cookie
 *
 * @see   xp://unittest.web.WebTestCase#getCookies
 * @see   xp://unittest.web.WebTestCase#getCookie
 */
class Cookie {
  private $name, $value, $attributes;

  public function __construct($name, $value, $attributes= []) {
    $this->name= $name;
    $this->value= $value;
    $this->attributes= $attributes;
  }

  /**
   * Parse a cookie from a header value
   *
   * @param  string $header
   * @return self
   * @throws lang.FormatException
   */
  public static function parse($header) {
    sscanf($header, '%[^=]=%[^;]', $name, $value);
    if (false === ($offset= strpos($header, ';'))) {
      return new self($name, $value);
    }

    $offset++;
    while (false !== ($p= strpos($header, '=', $offset))) {
      $key= ltrim(substr($header, $offset, $p - $offset), '; ');
      if ('"' === $header[$p + 1]) {
        $offset= $p + 2;
        do {
          if (false === ($offset= strpos($header, '"', $offset))) {
            throw new FormatException('Unclosed string in parameter "'.$name.'"');
          }
        } while ('\\' === $header[$offset++ - 1]);
        $attribute= strtr(substr($header, $p + 2, $offset - $p - 3), ['\"' => '"']);
      } else {
        $attribute= substr($header, $p + 1, strcspn($header, ';', $p) - 1);
        $offset= $p + strlen($attribute) + 1;
      }

      $attributes[$key]= $attribute;
    }
    return new self($name, $value, $attributes);
  }

  /** @return string */
  public function name() { return $this->name; }

  /** @return string */
  public function value() { return $this->value; }

  /** @return [:var] */
  public function attributes() { return $this->attributes; }
}