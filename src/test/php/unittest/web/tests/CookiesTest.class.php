<?php namespace unittest\web\tests;

use peer\http\HttpConstants;
use unittest\Test;
use unittest\web\Cookie;

class CookiesTest extends WebTestCaseTest {

  #[Test]
  public function no_cookies_present() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], '');
    $this->fixture->beginAt('/');
    $this->assertEquals([], $this->fixture->getCookies());
  }

  #[Test]
  public function single_cookie_present() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, ['Set-Cookie: uid=6100'], '');
    $this->fixture->beginAt('/');
    $this->assertEquals(['uid' => new Cookie('uid', '6100')], $this->fixture->getCookies());
  }

  #[Test]
  public function multiple_cookies_present() {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, ['Set-Cookie: uid=6100', 'Set-Cookie: session=abcd'], '');
    $this->fixture->beginAt('/');
    $this->assertEquals(
      ['uid' => new Cookie('uid', '6100'), 'session' => new Cookie('session', 'abcd')],
      $this->fixture->getCookies()
    );
  }
}