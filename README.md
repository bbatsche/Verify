# Verify

BDD Assertions for PHPUnit and Codeception

This is very tiny wrapper for PHPUnit assertions, that are aimed to make tests a bit more readable.
With BDD assertions influenced by Chai, Jasmine, and RSpec your assertions would be a bit closer to natural language.

[![Stories in Ready](https://badge.waffle.io/bbatsche/Verify.png?label=ready&title=Ready)](https://waffle.io/bbatsche/Verify)
[![Latest Stable Version](https://poser.pugx.org/bbat/verify/v/stable)](https://packagist.org/packages/bbat/verify)
[![Latest Unstable Version](https://poser.pugx.org/bbat/verify/v/unstable)](https://packagist.org/packages/bbat/verify)
[![Total Downloads](https://poser.pugx.org/bbat/verify/downloads)](https://packagist.org/packages/bbat/verify)
[![License](https://poser.pugx.org/bbat/verify/license)](https://packagist.org/packages/bbat/verify)
[![Build Status](https://travis-ci.org/bbatsche/Verify.png?branch=master)](https://travis-ci.org/Codeception/Verify)

Most of the original work was done by [@DavertMik](http://github.com/DavertMik) and [@Ragazzo](http://github.com/Ragazzo) in the [Codeception/Verify](http://github.com/Codeception/Verify) repo. This fork was created when it became apparent the original library was missing some key features and was all but abandoned.

## Contents

- [Installation](#installation)
- [Basic Usage](#basic-usage)
    - [Shorthand Functions](#shorthand-functions)
    - [Alternate Functions](#alternate-functions)
- [Available Assertions](#available-assertions)
    - [File Assertions](#file-assertions)
- [Additional Information](#additional-information)

## Installation

To install the current version of Verify from [Packagist](https://packagist.org/packages/bbat/verify), run the following in your project directory:

```bash
composer require --dev bbat/verify:~1.0@beta
```

Verify will be added to your `composer.json` under `require-dev` and installed in your `vendor` directory. You can then start using it in your unit tests.

## Basic Usage

To use Verify in your unit tests, call the `verify()` along with your expectation, like the following:

```php
$testValue = true;

verify($testValue)->isTrue();
```

That's it! You've now asserted that your `$testValue` is `true`! You can pass along a more detailed message for PHPUnit to display if your assertion fails like so:

```php
verify('test value should be false', $testValue)->isFalse();
```

### Shorthand Functions

There are two shortcut functions to quickly and easily assert a value is true or false (or more accurately, empty or not).

```php
verify_that($user->isActivated());

verify_not($user->isBanned());
```

### Alternate Functions

To better match TDD/BDD style, Verify also comes with `expect()` and `expect_*()` functions that act as aliases of the `verify()` function.

```php
expect($testValue)->equals('some other value');

expect('test value should not equal "bad value"', $testValue)->doesNotEqual("bad value");

expect_that($testModel->isValid());

expect_not($testModel->hasError());
```

## Available Assertions

By now you have hopefully noticed that Verify assertions read almost like plain English. The Verify assertions are crafted to optimize readability and understanding. Easy to parse tests are good tests. Currently, Verify supports the following assertions:

``` php
// Equity
verify($test)->equals('expected value');
verify($test)->doesNotEqual('unexpected value');

verify($objectInstance)->sameAs($sameObjectInstance);
verify($objectInstance)->notSameAs($aDifferentObject);

verify($test)->equalsFile('/path/to/file.txt');
verify($test)->doesNotEqualFile('/path/to/other/file.txt');

// Truthiness
verify($value)->isTrue();
verify($value)->isNotTrue();
verify($value)->isFalse();
verify($value)->isNotFalse();

verify($value)->isNull();
verify($value)->isNotNull();

verify($value)->isEmpty();
verify($value)->isNotEmpty();

// Numeric Comparison
verify($numericValue)->isGreaterThan($tooSmall);
verify($numericValue)->isGreaterOrEqualTo($min);
verify($numericValue)->isLessThan($tooBig);
verify($numericValue)->isLessOrEqualTo($max);

// String Values
verify($stringTest)->contains('expected value');
verify($stringTest)->doesNotContain('unexpected value');

verify($stringTest)->startsWith('start of string');
verify($stringTest)->doesNotStartWith('not start');
verify($stringTest)->endsWith('end of string');
verify($stringTest)->doesNotEndWIth('not the end');

verify($stringTest)->matchesRegExp('/[a-zA-Z]+/');
verify($stringTest)->doesNotMatchRegExp('/[0-9]+/');

verify($stringTest)->matchesFormat('%i');
verify($stringTest)->matchesFormatFile('/path/to/format.txt');
verify($stringTest)->doesNotMatchFormat('%x');
verify($stringTest)->doesNotMatchFormatFile('/path/to/other_format.txt');

// Array Elements
verify($arrayValue)->contains('expected value');
verify($arrayValue)->doesNotContain('unexpected value');

verify($arrayValue)->hasKey('some-key');
verify($arrayValue)->doesNotHaveKey('some-other-key');

verify($arrayValue)->hasCount(4);
verify($arrayValue)->doesNotHaveCount(1);
verify($arrayValue)->sameSizeAs($someOtherArray);
verify($arrayValue)->notSameSizeAs($aDifferentArray);

// // Contains only methods work for both object instances and internal types
verify($arrayValue)->containsOnly('string');
verify($arrayValue)->doesNotContainOnly('ClassName');

// Objects, Classes, and Internal Types
verify($object)->isInstanceOf('ClassName');
verify($object)->isNotInstanceOf('DifferentClassName');

verify($value)->isInternalType('int');
verify($value)->isNotInternalType('boolean');

verify($object)->hasAttribute('attributeName');
verify($object)->doesNotHaveAttribute('differentAttributeName');

verify('ClassName')->hasAttribute('attributeName');
verify('ClassName')->doesNotHaveAttribute('differentAttributeName');

verify('ClassName')->hasStaticAttribute('attributeName');
verify('ClassName')->doesNotHaveStaticAttribute('differentAttributeName');

// JSON and XML
verify($jsonValue)->isJson();

verify($jsonValue)->equalsJsonString('{"json": "string"}');
verify($jsonValue)->equalsJsonFile('/path/to/file.json');
verify($jsonValue)->doesNotEqualJsonString('{"bad": "json"}');
verify($jsonValue)->doesNotEqualJsonFile('/path/to/bad.json');

verify($domObj)->equalsXmlStructure($validDomObj);

verify($xmlString)->equalsXmlString('<valid><xml /></valid>');
verify($xmlString)->equalsXmlFile('/path/to/file.xml');
verify($xmlString)->doesNotEqualXmlString('<bad><xml /></bad>');
verify($xmlString)->doesNotEqualXmlFile('/path/to/bad.xml');
```

### File Assertions

If the subject under test is actually a file, you must use the `verify_file()` (or `expect_file()`) methods to access filesystem assertions.

```php
verify_file('/path/to/test.txt')->exists();
verify_file('/path/to/other.txt')->doesNotExist();

verify_file('/path/to/test.txt')->equals('/path/to/b.txt');
verify_file('/path/to/test.txt')->doesNotEqual('/path/to/c.txt');

verify_file('/path/to/test.json')->equalsJsonFile('/path/to/other.json');
verify_file('/path/to/test.json')->doesNotEqualJsonFile('/path/to/bad.json');

verify_file('/path/to/test.xml')->equalsXmlFile('/path/to/other.xml');
verify_file('/path/to/test.xml')->doesNotEqualXmlFile('/path/to/bad.xml');
```

## Additional Information

Full API documentation can be found on [GitHub Pages](http://bbatsche.github.io/Verify/). Any issues or questions can be submitted to [Waffle.io](https://waffle.io/bbatsche/Verify).
