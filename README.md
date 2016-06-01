# Verify

BDD Assertions for PHPUnit and Codeception

This is very tiny wrapper for PHPUnit assertions, that are aimed to make tests a bit more readable.
With BDD assertions influenced by Chai, Jasmine, and RSpec your assertions would be a bit closer to natural language.

[![Ready Stories](https://badge.waffle.io/bbatsche/Verify.png?label=ready&title=Ready)](https://waffle.io/bbatsche/Verify)
[![Stories In Progress](https://badge.waffle.io/bbatsche/Verify.png?label=in+progress&title=In+Progress)](https://waffle.io/bbatsche/Verify)
[![Latest Stable Version](https://img.shields.io/packagist/v/bebat/verify.svg?style=plastic)](https://packagist.org/packages/bebat/verify)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/bebat/verify.svg?style=plastic)](https://packagist.org/packages/bebat/verify)
[![Total Downloads](https://img.shields.io/packagist/dt/bebat/verify.svg?style=plastic)](https://packagist.org/packages/bebat/verify)
[![License](https://img.shields.io/packagist/l/bebat/verify.svg?style=plastic)](https://packagist.org/packages/bebat/verify)
[![Build Status](https://img.shields.io/travis/bbatsche/Verify.svg?style=plastic)](https://travis-ci.org/bbatsche/Verify)

Most of the original work was done by [@DavertMik](http://github.com/DavertMik) and [@Ragazzo](http://github.com/Ragazzo) in the [Codeception/Verify](http://github.com/Codeception/Verify) repo. This fork was created when it became apparent the original library was missing some key features and was all but abandoned.

## Contents

- [Installation](#installation)
- [Basic Usage](#basic-usage)
    - [Shorthand Functions](#shorthand-functions)
    - [Alternate Functions](#alternate-functions)
- [Available Assertions](#available-assertions)
    - [File Assertions](#file-assertions)
    - [Attribute Assertions](#attribute-assertions)
    - [Assertion Modifiers](#assertion-modifiers)
- [Additional Information](#additional-information)

## Installation

To install the current version of Verify from [Packagist](https://packagist.org/packages/bebat/verify), run the following in your project directory:

```bash
composer require --dev bebat/verify:~2.0@alpha
```

Verify will be added to your `composer.json` under `require-dev` and installed in your `vendor` directory. Verify takes advantage of PHP 5.6's ability to namespace functions, so to have it in your unit tests you should add `use function` statements to the top of your files:

```php
<?php

use function BeBat\Verify\verify;
use function BeBat\Verify\verify_file;
use function BeBat\Verify\verify_that;
use function BeBat\Verify\verify_not;

// ...
```

You can then start using it in your unit tests.

## Basic Usage

To use Verify in your unit tests, call the `verify()` function along with your expectation, like the following:

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

To better match TDD/BDD style, you may wish to give Verify's functions a different name like `expect()`. This can be done through the use of PHP 5.6's namespaced function aliases like so:

```php
use function BeBat\Verify\verify as expect;
use function BeBat\Verify\verify_file as expect_file;
use function BeBat\Verify\verify_that as expect_that;
use function BeBat\Verify\verify_not as expect_not;
```

Now, in your unit test code, you can write:

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

verify($arrayValue)->hasSubset($subsetOfValues);

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

### Attribute Assertions

Verify (and PHPUnit) has the ability to test the value of protected and private object properties (or "attributes"). While this is typically considered a violation of best unit testing practice, there are times when inspecting a protected value can be the simplest way of checking your code. The attribute you wish to check can be tacked on after calling `verify()`, just like if you were accessing it as a public value. For example, if you had an object called `$user` with a private `first_name` property that should be equal to `'Alice'`, you can assert that with the following code:

```php
verify($user)->first_name->equals('Alice');
```

The following subset of assertions support checking attribute values:

```php
verify($obj)->attribute_name->equals('Some Value');
verify($obj)->attribute_name->doesNotEqual('some other value');

verify($obj)->attribute_name->contains('Val');
verify($obj)->attribute_name->doesNotContain('unwanted value');

verify($obj)->array_attribute->hasCount(5);
verify($obj)->array_attribute->doesNotHaveCount(0);

verify($obj)->attribute_name->isEmpty();
verify($obj)->attribute_name->isNotEmpty();

verify($obj)->numeric_attribute->isGreaterThan(0);
verify($obj)->numeric_attribute->isGreaterOrEqualTo(1);
verify($obj)->numeric_attribute->isLessThan(10);
verify($obj)->numeric_attribute->isLessOrEqualTo(9.99);

verify($obj)->attribute_name->isInstanceOf('GoodClass');
verify($obj)->attribute_name->isNotInstanceOf('InvalidClass');
verify($obj)->attribute_name->isInternalType('string');
verify($obj)->attribute_name->isNotInternaltype('int');

verify($obj)->object_attriute->sameAs($validObject);
verify($obj)->object_attriute->notSameAs($invalidObject);

verify($obj)->array_attribute->containsOnly('bool');
verify($obj)->array_attribute->doesNotContainOnly('InvalidClassName');
```

If your attribute/property name conflicts with an existing `Verify` property, you can set it explicitly with the `attribute()` method:

```php
verify($obj)->attribute('isNot')->equals(false);
```

### File Assertions

If the subject under test is actually a file, you must use the `verify_file()` methods to access filesystem assertions.

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

### Assertion Modifiers

The behavior of many assertions can be tweaked inline with the test. These modifiers can be used to control case sensitivity, account for floating point errors, or strictness when checking for object identity and datatypes. They follow the naming convention of `with*()` and `without*()`. The available modifiers are:

```php
// Account for floating point errors
verify(0.1 + 0.2)->within(0.01)->equals(0.3);
verify(0.1 + 0.2)->within(0.01)->doesNotEqual(0.4);

// Control case sensitivity when comparing strings
verify('A String')->withCase()->equals('A String');
verify('A String')->withoutCase()->equals('a string');

verify('A String')->withCase()->doesNotEqual('a string');
verify('A String')->withoutCase()->doesNotEqual('another string');

verify('A String')->withCase()->contains('String');
verify('A String')->withoutCase()->contains('string');

verify('A String')->withCase()->doesNotContain('string');
verify('A String')->withoutCase()->doesNotContain('another');

verify('A String')->withCase()->equalsFile('/some/file.txt');
verify('a string')->withoutCase()->equalsFile('/some/file.txt');

verify('a string')->withCase()->doesNotEqualFile('/some/file.txt');
verify('A String')->withoutCase()->doesNotEqualFile('/some/other/file.txt');

verify_file('/some/file.txt')->withCase()->equals('/some/other/file.txt');
verify_file('/some/file.txt')->withoutCase()->equals('/some/other/file.txt');

verify_file('/some/file.txt')->withCase()->doesNotEqual('/yet/another/file.txt');
verify_file('/some/file.txt')->withoutCase()->doesNotEqual('/another/file.txt');

// Whether to check element ordering when comparing two arrays
verify([1, 2, 3])->withOrder()->equals([1, 2, 3]);
verify([1, 2, 3])->withoutOrder()->equals([3, 1, 2]);

verify([1, 2, 3])->withOrder()->doesNotEqual([3, 1, 2]);
verify([1, 2, 3])->withoutOrder()->doesNotEqual([3, 1, 1]);

// Whether to check for identity when comparing object values
verify([$objectA])->withIdentity()->contains($objectA);
verify([$objectA])->withoutIdentity()->contains($objectB);

verify([$objectA])->withIdentity()->doesNotContain($objectB);
verify([$objectA])->withoutIdentity()->doesNotContain($objectB);

// Whether to include type when comparing values
verify(['1', '2'])->withType()->contains('1');
verify(['1', '2'])->withoutType()->contains(1);

verify(['1', '2'])->withType()->doesNotContain('3');
verify(['1', '2'])->withoutType()->doesNotContain(3);

verify(['1', '2', '3'])->withType()->hasSubset(['1', '3']);
verify(['1', '2', '3'])->withoutType()->hasSubset([1, 3]);

// Whether to check element attributes when comparing XML documents
verify($domDocument)->withAttributes()->equalsXmlStructure($validDocument);
verify($domDocument)->withoutAttributes()->equalsXmlStructure($validDocument);
```

Assertion modifiers can be combined with each other, or with attribute assertions:

```php
verify($obj)->string_attribute->withoutCase()->equals('some value');
```

## Additional Information

Full API documentation can be found on [GitHub Pages](http://bbatsche.github.io/Verify/). Any issues or questions can be submitted to [Waffle.io](https://waffle.io/bbatsche/Verify).
