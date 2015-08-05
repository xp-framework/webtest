Webtest
=======

[![Build Status on TravisCI](https://secure.travis-ci.org/xp-framework/webtest.svg)](http://travis-ci.org/xp-framework/webtest)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Required PHP 5.4+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-5_4plus.png)](http://php.net/)
[![Supports PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.png)](http://php.net/)
[![Supports HHVM 3.4+](https://raw.githubusercontent.com/xp-framework/web/master/static/hhvm-3_4plus.png)](http://hhvm.com/)
[![Latest Stable Version](https://poser.pugx.org/xp-framework/webtest/version.png)](https://packagist.org/packages/xp-framework/webtest)

Web tests for the XP Framework

Example
-------
The following web test case consists of opening GitHub's homepage and asserting the title to equal the company's name:

```php
use unittest\web\WebTestCase;
use peer\http\HttpConstants;
use peer\http\HttpConnection;

class GitHubTestCase extends WebTestCase {

  /**
   * Get connection
   *
   * @param   string url
   * @return  peer.http.HttpConnection
   */
  protected function getConnection($url= null) {
    return new HttpConnection($url ?: 'https://github.com/');
  }

  #[@test]
  public function home() {
    $this->beginAt('/');
    $this->assertStatus(HttpConstants::STATUS_OK);
    $this->assertTitleEquals('GitHub · Build software better, together.');
  }
}
```

Running it works as with normal test cases:

```sh
$ unittest GitHubTestCase
[.]

✓: 1/1 run (0 skipped), 1 succeeded, 0 failed
Memory used: 1861.12 kB (2474.66 kB peak)
Time taken: 1.225 seconds
```

Assertion methods
-----------------
On top of the assertion methods provided by the unittest library, the following response-related assertions are available:

```php
public void assertStatus(int $status, string $message= 'not_equals')
public void assertUrlEquals(peer.URL $url, string $message= 'not_equals')
public void assertContentType(string $ctype, string $message= 'not_equals')
public void assertHeader(string $header, string $value, string $message= 'not_equals')
public void assertElementPresent(string $id, string $message= 'not_present')
public void assertTextPresent(string $text, string $message= 'not_present')
public void assertImagePresent(string $src, string $message= 'not_present')
public void assertLinkPresent(string $url, string $message= 'not_present')
public void assertLinkPresentWithText(string $text, string $message= 'not_present')
public void assertFormPresent(string $name= null, string $message= 'not_present')
public void assertTitleEquals($title, string $message= 'not_equals')
```

Navigation
----------
To follow links inside a page, a web test can utilize the click methods:

```php
protected void clickLink(string $id);
protected void clickLinkWithText(string $text);
```

Forms
-----
To work with forms, the `getForm()` method can be used:

```php
use unittest\web\WebTestCase;
use peer\http\HttpConstants;
use peer\http\HttpConnection;

class GitHubTestCase extends WebTestCase {

  /**
   * Get connection
   *
   * @param   string url
   * @return  peer.http.HttpConnection
   */
  protected function getConnection($url= null) {
    return new HttpConnection($url ?: 'https://github.com/');
  }

  #[@test]
  public function search_for() {
    $this->beginAt('/');
    $form= $this->getForm();
    $form->getField('q')->setValue('XP Framework');
    $form->submit();
    $this->assertStatus(HttpConstants::STATUS_OK);
    $this->assertTitleEquals('Search · XP Framework · GitHub');
  }
}
```

See also
--------
https://github.com/xp-framework/rfc/issues/169