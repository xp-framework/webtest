Web tests change log
====================

## ?.?.? / ????-??-??

## 7.1.0 / 2022-03-04

* Fixed *urlencode(): Passing null to parameter [...] of type string is
  deprecated* warnings in PHP 8
  (@thekid)
* Added compatibility with XP 11, newer dependency versions - @thekid

## 7.0.0 / 2020-04-05

* Implemented xp-framework/rfc#334: Drop PHP 5.6. The minimum required
  PHP version is now 7.0.0!
  (@thekid)

## 6.6.0 / 2020-04-05

* Added `WebTestCase::getCookies()` to access all cookies - @thekid
* Made compatible with XP 10 - @thekid
* Removed dependency on scriptlet library - @thekid

## 6.5.1 / 2015-12-20

* Added dependency on logging, patterns and networking libraries which
  have since been extracted from XP core.
  (@thekid)

## 6.5.0 / 2015-12-13

* **Heads up**: Changed minimum XP version to run webtests to XP
  6.5.0, and with it the minimum PHP version to PHP 5.5
  (@thekid)

## 6.4.4 / 2015-08-22

* Introduced new `@webtest` annotation replacing necessity to overwrite
  the `getConnection()` method. See xp-framework/webtest#3
  (@thekid)

## 6.4.3 / 2015-08-06

* Fixed `assertTextPresent()` also taking head section into account, now
  only looks inside HTML body
  (@thekid)
* Fixed issue #1: Problem with HTML w/o encoding - @thekid

## 6.4.2 / 2015-08-06

* MFH: Fixed DOM not being loaded on HHVM due to `loadHTMLFile()` not
  working with URLs (or userland streams!) except if an ini setting
  unchangeable at runtime contains the stream protocol. See also
  http://stackoverflow.com/questions/27603084/hhvm-domdocument-loadhtmlfile-not-working-bug
  (@thekid)
* MFH: Fixed `doRequest()` with lower- or mixed-case variants of the
  HTTP method, e.g. "get".
  (@thekid)
* MFH: Fixed WebTestCase test class using obsolete `assertClass()` - @thekid
* MFH: Fixed `SelectField::setValue()` double-encoding UTF8 - @thekid
* MFH: Fixed syntax errors in `unittest.web` package  - @thekid
* **Heads up: Split library from xp-framework/core as per xp-framework/rfc#293**
  (@thekid)
