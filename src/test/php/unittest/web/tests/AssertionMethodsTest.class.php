<?php namespace unittest\web\tests;

use unittest\web\WebTestCase;
use io\streams\MemoryInputStream;
use peer\http\HttpConnection;
use peer\http\HttpResponse;
use peer\http\HttpConstants;
use peer\URL;

class AssertionMethodsTest extends \unittest\TestCase {
  private $fixture;

  /** @return void */
  public function setUp() {
    $this->fixture= newinstance('unittest.web.WebTestCase', [$this->name], [
      'response' => null,
      'getConnection' => function($url= null) {
        return new HttpConnection('http://localhost/');
      },
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

  #[@test]
  public function assertStatus() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertStatus(HttpConstants::STATUS_OK);
  }

  #[@test]
  public function assertStatusIn() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertStatusIn([HttpConstants::STATUS_OK]);
  }

  #[@test]
  public function assertUrlEquals() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertUrlEquals(new URL('http://localhost/'));
  }

  #[@test]
  public function assertContentType() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, ['Content-Type: text/plain'], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertContentType('text/plain');
  }

  #[@test]
  public function assertHeader() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, ['ETag: "214ceb4b-980-3a7bbd9630480"'], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertHeader('ETag', '"214ceb4b-980-3a7bbd9630480"');
  }

  #[@test]
  public function assertTitleEquals() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><head><title>Test</title></heady><body/></html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertTitleEquals('Test');
  }
}
