<?php namespace unittest\web\tests;

use peer\http\HttpConstants;
use unittest\Test;

class ImagesTest extends WebTestCaseTest {

  #[Test]
  public function images() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], trim('
      <html>
        <head>
          <title>Images</title>
        </head>
        <body>
          <img src="/static/blank.gif"/>
          <!-- <img src="http://example.com/example.png"/> -->
          <img src="http://example.com/logo.jpg"/>
        </body>
      </html>
    '));

    $this->fixture->beginAt('/');
    $this->fixture->assertImagePresent('/static/blank.gif');
    $this->fixture->assertImageNotPresent('http://example.com/example.png');
    $this->fixture->assertImageNotPresent('logo.jpg');
    $this->fixture->assertImagePresent('http://example.com/logo.jpg');
  }
}