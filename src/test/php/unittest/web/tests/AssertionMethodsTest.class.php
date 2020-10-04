<?php namespace unittest\web\tests;

use peer\URL;
use peer\http\HttpConstants;
use text\regex\Pattern;
use unittest\Test;

class AssertionMethodsTest extends WebTestCaseTest {

  #[Test]
  public function assertStatus() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertStatus(HttpConstants::STATUS_OK);
  }

  #[Test]
  public function assertStatusIn() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertStatusIn([HttpConstants::STATUS_OK]);
  }

  #[Test]
  public function assertUrlEquals() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertUrlEquals(new URL('http://localhost/'));
  }

  #[Test]
  public function assertContentType() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, ['Content-Type: text/plain'], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertContentType('text/plain');
  }

  #[Test]
  public function assertContentType_with_charset() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, ['Content-Type: text/xml; charset=utf-8']);
    $this->fixture->beginAt('/');
    $this->fixture->assertContentType('text/xml; charset=utf-8');
  }

  #[Test]
  public function assertHeader() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, ['ETag: "214ceb4b-980-3a7bbd9630480"'], '');
    $this->fixture->beginAt('/');
    $this->fixture->assertHeader('ETag', '"214ceb4b-980-3a7bbd9630480"');
  }

  #[Test]
  public function assertElementPresent() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><body><div id="content"/></html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertElementPresent('content');
  }

  #[Test]
  public function assertTextPresent() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><body>Content</html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertTextPresent('Content');
  }

  #[Test]
  public function assertTextPatternPresent() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><body>Content</html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertTextPatternPresent(new Pattern('content', Pattern::CASE_INSENSITIVE));
  }

  #[Test]
  public function assertImagePresent() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><body><img src="blank.gif"/></html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertImagePresent('blank.gif');
  }

  #[Test]
  public function assertLinkPresent() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><body><a href="http://example.com/">.</a></html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertLinkPresent('http://example.com/');
  }

  #[Test]
  public function assertLinkPresentWithText() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><body><a href="http://example.com/">Example</a></html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertLinkPresentWithText('Example');
  }

  #[Test]
  public function assertFormPresent_without_name() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><body><form></form></html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertFormPresent();
  }

  #[Test]
  public function assertFormPresent_with_name() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><body><form name="login"></form></html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertFormPresent('login');
  }

  #[Test]
  public function assertTitleEquals() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '<html><head><title>Test</title></head><body/></html>');
    $this->fixture->beginAt('/');
    $this->fixture->assertTitleEquals('Test');
  }
}