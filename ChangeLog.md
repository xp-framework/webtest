Web tests change log
====================

## ?.?.? / ????-??-??

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
