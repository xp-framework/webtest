<?php namespace unittest\web\tests;

use peer\http\HttpConstants;
use unittest\Test;

class LinksTest extends WebTestCaseTest {

  #[Test]
  public function links() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], trim('
      <html>
        <head>
          <title>Links</title>
        </head>
        <body>
          <a href="http://example.com/test">Test</a>
          <a href="/does-not-exist">404</a>
          <!-- <a href="comment.html">Hidden</a> -->
        </body>
      </html>
    '));

    $this->fixture->beginAt('/');
    $this->fixture->assertLinkPresent('http://example.com/test');
    $this->fixture->assertLinkPresent('/does-not-exist');
    $this->fixture->assertLinkNotPresent('comment.html');
    $this->fixture->assertLinkNotPresent('index.html');
  }

  #[Test]
  public function linksWithText() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], trim('
      <html>
        <head>
          <title>Links</title>
        </head>
        <body>
          <a href="http://example.com/test">Test</a>
          <a href="/does-not-exist">404</a>
          <!-- <a href="comment.html">Hidden</a> -->
        </body>
      </html>
    '));

    $this->fixture->beginAt('/');
    $this->fixture->assertLinkPresentWithText('Test');
    $this->fixture->assertLinkPresentWithText('404');
    $this->fixture->assertLinkNotPresentWithText('Hidden');
    $this->fixture->assertLinkNotPresentWithText('Hello');
  }
}