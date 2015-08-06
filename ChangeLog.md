Web tests change log
====================

## ?.?.? / ????-??-??

* MFH: Fixed DOM not being loaded on HHVM due to `loadHTMLFile()` not
  working with URLs (or userland streams!) except if an ini setting
  unchangeable at runtime contains the stream protocol. See also
  http://stackoverflow.com/questions/27603084/hhvm-domdocument-loadhtmlfile-not-working-bug
  (@thekid)
* MFH: Fixed `doRequest()` with lower- or mixed-case variants of the
  HTTP method, e.g. "get".
  (@thekid)
* MFH: Fixed `unittest.XmlTestListener::uriFor()` raising exceptions - @thekid
* MFH: Fixed WebTestCase test class using obsolete `assertClass()` - @thekid
* MFH: Fixed `SelectField::setValue()` double-encoding UTF8 - @thekid
* MFH: Fixed syntax errors in `unittest.web` package  - @thekid
* **Heads up: Split library from xp-framework/core as per xp-framework/rfc#293**
  (@thekid)