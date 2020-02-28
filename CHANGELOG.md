# Changelog

## 9.0.2, 2020-02-28

* Updated Facebook Graph API to version 6.0. (richard67)
* Fixed readme. (richard67)

## 9.0.1, 2020-02-24

* Fixed release process.

## 9.0.0, 2020-02-24

* Updated dependencies.
* Replaced Zend dependencies with Laminas. (vkhramtsov)

This release contains breaking changes:

* Dropped support for PHP 7.1.

## 8.2.2, 2020-01-09

* Updated Facebook Graph API to version 5.0. (richard67)

## 8.2.1, 2019-08-20

* Updated Facebook Graph API to version 4.0. (richard67)

## 8.2.0, 2019-06-27

* Removed LinkedIn service. (richard67)

## 8.1.2, 2019-06-12

* Updated dependencies. (liayn)

## 8.1.1, 2019-05-27

* Updated Facebook Graph API to version 3.3. (richard67)

## 8.1.0, 2019-04-01

* Updated dependencies.
* Added buffer service. (richard67)

## 8.0.0, 2018-11-29

* Updated Facebook Graph API to version 3.2. (richard67)
* Updated composer dependencies.
* Improved Pinterest service to send requests using HTTPS. (vkhramtsov)
* Improved readme. (Art4)

This release contains breaking changes:

* Dropped support for PHP 5.6.
* Dropped support for PHP 7.0.

## 7.1.4 2018-08-30

* Updated Facebook Graph API to version 3.1. (richard67)

## 7.1.3 2018-05-30

* Updated Facebook Graph API to version 3. (richard67)

## 7.1.2 2018-05-25

* Updated `guzzle` and `phpunit` dependencies. (liayn)

## 7.1.1 2018-02-23

* Fixed handling of removed services. (liayn, richard67)
* Fixed crashes caused by failures of single services.
* Updated Facebook Graph API to version 2.12. (richard67)
* Removed Google+ service. (richard67)
* Removed deprecated Node.js and Perl backends from documentation. (richard67)

## 7.1.0 2018-01-26

* Added support for Vk. (richard67)

## 7.0.2 2017-12-04

* Updated Facebook Graph API to version 2.11. (richard67)

## 7.0.1 2017-11-20

* Updated Facebook Graph API to version 2.10. (richard67)

## 7.0.0 2017-03-30

* Updated Facebook Graph API to version 2.8. (liayn)
* Removed Facebook FQL API. (liayn)
* Fixed fatal error in case of unparseable service results. (NeoBlack)

## 6.0.1 2017-02-07

* Updated composer dependencies. (liayn)

## 6.0.0 2016-08-16

* Dropped support for PHP 5.5.
* Dropped support for JSON configuration. (liayn)
* Updated composer dependencies. (liayn, core23)
* Removed unused HHVM specific code. (liayn)
* Removed unnecessary files from composer package. (core23)
* Removed unnecessary composer dependencies. (liayn)
* Clarified description of domains parameter. (cmb69)

## 5.2.3 2016-04-01

* Fixed backwards compatibility break. (liayn)

## 5.2.2 2016-03-31

* Re-release of 5.2.1 because of wrong tag.

## 5.2.1 2016-03-31

* Fixed handling of Guzzle request options. (liayn)
* Removed non CLI command from composer. (core23)

## 5.2.0 2016-02-24

* Added support for blank domains. (core23)
* Fixed possible error caused by deprecation warning. (core23)

## 5.1.0 2016-02-18

* Added support for multiple domains. (liayn, core23, compeak)
* Improved checking of Facebook configuration. (liayn)

## 5.0.0 2016-02-03

* Added support for PHP 7. (core23, liayn)
* Dropped support for HHVM. (core23, liayn)

## 4.1.0 2016-02-01

* Cleaned up PHPDoc comments. (core23)
* Improved exception handling of Facebook backend. (core23)
* Added logger. (core23)
* Added PHP-CS-Fixer to standardise code format. (core23)

## 4.0.2 2016-01-27

* Fixed array keys not being checked for existence. (liayn, wmtech-1)
* Fixed encoding of urls passed to Facebook. (liayn, hokascha)

## 4.0.1 2016-01-11

* Re-added necessary dependencies.

## 4.0.0 2016-01-07

* Cleaned up dependencies. (core23)
* Dropped support for PHP 5.4. (core23)

## 3.0.1 2015-12-03

* Updated installation instructions.
* Optimized build process.

## 3.0.0 2015-12-02

* Removed build artifacts from repository.
* Cleaned up testing. (liayn)
* Fixed phpUnit dependencies. (liayn)
* Introduced changelog.
