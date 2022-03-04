Webtest
=======

[![Build status on GitHub](https://github.com/xp-framework/webtest/workflows/Tests/badge.svg)](https://github.com/xp-framework/webtest/actions)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Requires PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.svg)](http://php.net/)
[![Supports PHP 8.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-8_0plus.svg)](http://php.net/)
[![Latest Stable Version](https://poser.pugx.org/xp-framework/webtest/version.png)](https://packagist.org/packages/xp-framework/webtest)

Web tests for the XP Framework

Example
-------
The following web test case consists of opening GitHub's homepage and asserting the title to equal the company's name:

```php
use unittest\web\{WebTestCase, Webtest};
use unittest\Test;

#[Webtest(url: 'https://github.com/')]
class GitHubTestCase extends WebTestCase {

  #[Test]
  public function home() {
    $this->beginAt('/');
    $this->assertStatus(200);
    $this->assertTitleEquals('GitHub: Where the world builds software · GitHub');
  }
}
```

Running it works as with normal test cases:

```sh
$ xp test GitHubTestCase
[.]

✓: 1/1 run (0 skipped), 1 succeeded, 0 failed
Memory used: 1861.12 kB (2474.66 kB peak)
Time taken: 1.225 seconds
```

To overwrite the default URL specified in the annotation, supply it as command line argument, e.g. `unittest GitHubTestCase -a https://github.staging.lan/`.

Assertion methods
-----------------
On top of the assertion methods provided by the unittest library, the following response-related assertions are available:

```php
public void assertStatus(int $status)
public void assertUrlEquals(peer.URL $url)
public void assertContentType(string $ctype)
public void assertHeader(string $header, string $value)
public void assertElementPresent(string $id)
public void assertTextPresent(string $text)
public void assertImagePresent(string $src)
public void assertLinkPresent(string $url)
public void assertLinkPresentWithText(string $text)
public void assertFormPresent(string $name= null)
public void assertTitleEquals($title)
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
use unittest\web\{WebTestCase, Webtest};
use unittest\Test;

#[Webtest(url: 'https://github.com/')]
class GitHubTestCase extends WebTestCase {

  #[Test]
  public function search_for() {
    $this->beginAt('/');
    $form= $this->getForm();
    $form->getField('q')->setValue('XP Framework');
    $form->submit();
    $this->assertStatus(200);
    $this->assertTitleEquals('Search · XP Framework · GitHub');
  }
}
```

See also
--------
https://github.com/xp-framework/rfc/issues/169