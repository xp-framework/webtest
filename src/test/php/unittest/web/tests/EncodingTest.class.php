<?php namespace unittest\web\tests;

use peer\http\HttpConstants;

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
      [sprintf(self::$FIXTURE, '<meta charset="utf-8">')],
      [sprintf(self::$FIXTURE, '<meta http-equiv="content-type" content="text/html; charset=utf-8">')],
      [sprintf(utf8_decode(self::$FIXTURE), '<meta charset="iso-8859-1">')],
      [sprintf(utf8_decode(self::$FIXTURE), '<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">')],
      [sprintf(self::$FIXTURE, '<!-- No meta tag -->')]
    ];
  }

  #[@test, @values('fixtures')]
  public function title($fixture) {
    $this->fixture->respondWith(HttpConstants::STATUS_OK, [], $fixture);
    $this->fixture->beginAt('/');
    $this->fixture->assertTitleEquals('Über-Tests');
  }
}