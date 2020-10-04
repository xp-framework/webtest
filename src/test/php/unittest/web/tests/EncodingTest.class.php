<?php namespace unittest\web\tests;

use peer\http\HttpConstants;
use text\regex\Pattern;
use unittest\{Test, Values};

class EncodingTest extends WebTestCaseTest {
  private static $FIXTURE;

  static function __static() {
    self::$FIXTURE= trim('
      <html>
        <head>
          %s
          <title>Über-Tests</title>
        </head>
        <body>
          This is an <a href="http://example.com/">Über-Example</a> inside the über tests.
          <form>
            <input type="text" name="uber" value="Übercoder"/>
            <select name="gender">
              <option value="U">Überwoman</option>
            </select>
            <textarea name="umlauts">Übercoder</textarea>
          </form>
        </body>
      </html>
    ');
  }

  /** @return var[][] */
  private function fixtures() {
    return [
      [[], sprintf(self::$FIXTURE, '<meta charset="utf-8">')],
      [[], sprintf(self::$FIXTURE, '<meta http-equiv="content-type" content="text/html; charset=utf-8">')],
      [[], sprintf(utf8_decode(self::$FIXTURE), '<meta charset="iso-8859-1">')],
      [[], sprintf(utf8_decode(self::$FIXTURE), '<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">')],
      [[], sprintf(utf8_decode(self::$FIXTURE), '<!-- No meta tag -->')],
      [['Content-Type: text/html; charset=utf-8'], sprintf(self::$FIXTURE, '<!-- No meta tag -->')],
      [['Content-Type: text/html'], sprintf(utf8_decode(self::$FIXTURE), '<!-- No meta tag -->')],
      [['Content-Type: text/html; charset=iso-8859-1'], sprintf(utf8_decode(self::$FIXTURE), '<!-- No meta tag -->')]
    ];
  }

  #[Test, Values('fixtures')]
  public function title($headers, $fixture) {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, $headers, $fixture);
    $this->fixture->beginAt('/');
    $this->fixture->assertTitleEquals('Über-Tests');
  }

  #[Test, Values('fixtures')]
  public function link($headers, $fixture) {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, $headers, $fixture);
    $this->fixture->beginAt('/');
    $this->fixture->assertLinkPresentWithText('Über-Example');
  }

  #[Test, Values('fixtures')]
  public function input($headers, $fixture) {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, $headers, $fixture);
    $this->fixture->beginAt('/');
    $this->assertEquals('Übercoder', $this->fixture->getForm()->getField('uber')->getValue());
  }

  #[Test, Values('fixtures')]
  public function option($headers, $fixture) {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, $headers, $fixture);
    $this->fixture->beginAt('/');
    $this->assertEquals('Überwoman', $this->fixture->getForm()->getField('gender')->getOptions()[0]->getText());
  }

  #[Test, Values('fixtures')]
  public function textarea($headers, $fixture) {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, $headers, $fixture);
    $this->fixture->beginAt('/');
    $this->assertEquals('Übercoder', $this->fixture->getForm()->getField('umlauts')->getValue());
  }

  #[Test, Values('fixtures')]
  public function text($headers, $fixture) {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, $headers, $fixture);
    $this->fixture->beginAt('/');
    $this->fixture->assertTextPresent('über tests');
  }

  #[Test, Values('fixtures')]
  public function pattern($headers, $fixture) {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, $headers, $fixture);
    $this->fixture->beginAt('/');
    $this->fixture->assertTextPatternPresent(new Pattern('[üu]ber tests'));
  }
}