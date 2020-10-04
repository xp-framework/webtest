<?php namespace unittest\web\tests;

use peer\http\HttpConstants;
use unittest\Test;

class ElementsTest extends WebTestCaseTest {

  #[Test]
  public function elements() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], trim('
      <html>
        <head>
          <title>Elements</title>
        </head>
        <body>
          <div id="header"/>
          <!-- <div id="navigation"/> -->
          <div id="main"/>
        </body>
      </html>
    '));

    $this->fixture->beginAt('/');
    $this->fixture->assertElementPresent('header');
    $this->fixture->assertElementNotPresent('footer');
    $this->fixture->assertElementPresent('main');
    $this->fixture->assertElementNotPresent('footer');
  }
}