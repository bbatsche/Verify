# Verify

BDD Assertions for PHPUnit and Codeception

This is very tiny wrapper for PHPUnit assertions, that are aimed to make tests a bit more readable.
With BDD assertions influenced by Chai, Jasmine, and RSpec your assertions would be a bit closer to natural language.

[![Latest Stable Version](https://img.shields.io/packagist/v/bebat/verify.svg?style=plastic)](https://packagist.org/packages/bebat/verify)
[![Total Downloads](https://img.shields.io/packagist/dt/bebat/verify.svg?style=plastic)](https://packagist.org/packages/bebat/verify)
[![License](https://img.shields.io/packagist/l/bebat/verify.svg?style=plastic)](https://packagist.org/packages/bebat/verify)
[![Build Status](https://img.shields.io/travis/bbatsche/Verify.svg?style=plastic)](https://travis-ci.org/bbatsche/Verify)
[![Code Coverage](https://codecov.io/gh/bbatsche/Verify/branch/master/graph/badge.svg)](https://codecov.io/gh/bbatsche/Verify)

Most of the original work was done by [@DavertMik](http://github.com/DavertMik) and [@Ragazzo](http://github.com/Ragazzo) in the [Codeception/Verify](http://github.com/Codeception/Verify) repo. This fork was created to address some issues and then expand the API & feature set.

# Contents

- [Installation](#installation)
    - [Compatibility](#compatibility)
- [Basic Usage](#basic-usage)
    - [Alternate Functions](#alternate-functions)
- [Conjunctions](#conjunctions)
    - [Custom Conjunctions](#custom-conjunctions)
- [Available Assertions](#available-assertions)
    - [File Assertions](#file-assertions)
    - [Directory Assertions](#directory-assertions)
    - [Attribute Assertions](#attribute-assertions)
    - [Assertion Modifiers](#assertion-modifiers)
- [Chaining Assertions](#chaining-assertions)

## Installation

To install the current version of Verify from [Packagist](https://packagist.org/packages/bebat/verify), run the following in your project directory:

```bash
composer require --dev bebat/verify
```

Verify will be added to your `composer.json` under `require-dev` and installed in your `vendor` directory.

### Compatibility

As stated, Verify is built on top of PHPUnit's own assertions. It has been written to be compatibile with any version of PHPUnit from 6.0 through 9.x. That said, some assertions have been removed from later versions of PHPUnit, and others added. Those assertions are noted in documentation below. When using Verify, it is still good practice to declare what version of PHPUnit your project depends on so that there are no surprise compatibility issues.

In addition, Verify is compatibile with any version of PHP 7. You should have no issues integrating it into your legacy projects.

## Basic Usage

Verify uses namespaced functions, so to include it in your unit tests you should add `use function` statements to the top of your files:

```php
// assertions for code
use function BeBat\Verify\verify;
// assertions for files
use function BeBat\Verify\verify_file;
// assertions for directories
use function BeBat\Verify\verify_directory;
````

To use Verify in your unit tests, call the `verify()` function, followed by one or more conjunction, and then your assertion(s). For example:

```php
$testValue = true;

verify($testValue)->is()->true();
```

That's it! You've now asserted that your `$testValue` is `true`! You can pass along a more detailed message for PHPUnit to display if your assertion fails like so:

```php
verify('test value should be false', $testValue)->is()->false();
```

### Alternate Functions

To better match TDD/BDD style, you may wish to give Verify's functions a different name like `expect()`. This can be done through the use of function aliases like so:

```php
use function BeBat\Verify\verify as expect;
use function BeBat\Verify\verify_file as expect_file;
use function BeBat\Verify\verify_directory as expect_directory;
```

Now, in your unit test code, you can write:

```php
expect($testValue)->will()->be()->equalTo('some other value');

expect('test value should not equal "bad value"', $testValue)->willNot()->be()->equalTo("bad value");
```

## Conjunctions

Conjunctions are used tie your *subject* to your *assertions*. They control whether the assertion is "positive" (ie, assert that subject *is* a certain value) or "negative" (subject *is not* a certain value). There are also "neutral" conjunctions that do not change whether the assertion is positive or negative; they can be used to make your tests a bit more readable. The default set of conjunctions are as follows:

- **Positive**
    - `is()`
    - `will()`
    - `does()`
    - `has()`
- **Negative**
    - `isNot()`
    - `willNot()`
    - `doesNot()`
- **Neutral**
    - `be()`
    - `have()`
    - `and()`

### Custom Conjunctions

Conjunctions are configured through a set of static arrays of strings in `BeBat\Verify\VerifyBase`. This is done so that they can be tailored to developers' native grammar and language patterns if necessary. You can manipulate these value like you would any other array. For example:

```php
BeBat\Verify\Verify::$positiveConjunctions[] = 'to';
BeBat\Verify\Verify::$positiveConjunctions[] = 'should';

BeBat\Verify\Verify::$negativeConjunctions[] = 'shouldNot';

BeBat\Verify\Verify::$neutralConjunctions[] = 'also';
BeBat\Verify\Verify::$neutralConjunctions[] = 'or';
```

This should be performed somewhere in your test suite's bootstrap code so that it is done before any assertions are called and is shared across your tests.

## Available Assertions

By now you have hopefully noticed that Verify assertions read almost like plain English. The Verify assertions are crafted to optimize readability and understanding. Easy to parse tests are good tests. Currently, Verify supports the following assertions:

``` php
// Equity
verify($test)->is()->equalTo('expected value');

verify($objectInstance)->is()->sameAs($sameObjectInstance);

verify($test)->is()->equalToFile('/path/to/file.txt');


// Truthiness
verify($value)->is()->true();
verify($value)->is()->false();

verify($value)->is()->null();

verify($value)->is()->empty();


// Type
verify($object)->is()->instanceOf('ClassName');
verify($value)->is()->internalType('int');
// Note: internalType() was deprecated in PHPUnit 8, and removed in version 9

// Node: The following assertions were added in PHPUnit 7
verify($value)->is()->array();
verify($value)->is()->bool();
verify($value)->is()->callable();
verify($value)->is()->float();
verify($value)->is()->int();
verify($value)->is()->iterable();
verify($value)->is()->numeric();
verify($value)->is()->object();
verify($value)->is()->resource();
verify($value)->is()->scalar();
verify($value)->is()->string();


// Numeric Comparison
verify($numericValue)->is()->greaterThan($tooSmall);
verify($numericValue)->is()->greaterOrEqualTo($min);
verify($numericValue)->is()->lessThan($tooBig);
verify($numericValue)->is()->lessOrEqualTo($max);

verify($numericValue)->is()->finite();
verify($numericValue)->is()->infinite();
verify($numericValue)->is()->nan();
// Note: nan() does not support negative assertions


// String Values
verify($stringTest)->will()->contain('expected value');

verify($stringTest)->will()->startWith('start of string');
verify($stringTest)->will()->endWith('end of string');

verify($stringTest)->will()->matchRegExp('/[a-zA-Z]+/');

verify($stringTest)->will()->matchFormat('%i');
verify($stringTest)->will()->matchFormatFile('/path/to/format.txt');


// Array Elements
verify($arrayValue)->will()->contain('expected value');

verify($arrayValue)->will()->have()->subset($subsetOfValues);
// Note: subset() does not support negative assertions
// Note: subset() was deprecated in PHPUnit 8, and removed in version 9

verify($arrayValue)->will()->have()->key('some-key');

verify($arrayValue)->has()->count(4);
verify($arrayValue)->is()->sameSizeAs($someOtherArray);

// // Contains only methods work for both object instances and internal types
verify($arrayValue)->will()->containOnly('string');


// Object & Class Properties
verify($object)->has()->attribute('attributeName');
verify('ClassName')->has()->attribute('attributeName');
verify('ClassName')->has()->staticAttribute('attributeName');


// JSON and XML
verify($jsonValue)->is()->json();
// Note: json() does not support negative assertions

verify($jsonValue)->is()->equalToJsonString('{"json": "string"}');
verify($jsonValue)->is()->equalToJsonFile('/path/to/file.json');

verify($domObj)->is()->equalToXmlStructure($validDomObj);
// Note: equalToXmlStructure() does not support negative assertions

verify($xmlString)->is()->equalToXmlString('<valid><xml /></valid>');
verify($xmlString)->is()->equalToXmlFile('/path/to/file.xml');
```

### File Assertions

If the subject under test is a file, you must use the `verify_file()` function to access filesystem assertions.

```php
verify_file('/path/to/test.txt')->does()->exist();
verify_file('/path/to/test.txt')->is()->readable();
verify_file('/path/to/test.txt')->is()->writable();

verify_file('/path/to/test.txt')->is()->equalTo('/path/to/b.txt');
verify_file('/path/to/test.json')->is()->equalToJsonFile('/path/to/other.json');
verify_file('/path/to/test.xml')->is()->equalToXmlFile('/path/to/other.xml');
```

### Directory Assertions

There are also a handful of assertions specific to directories. To call these assertions, use the `verify_directory()` function.

```php
verify_directory('/path/to/test/dir')->does()->exist();
verify_directory('/path/to/test/dir')->is()->readable();
verify_directory('/path/to/test/dir')->is()->writable();
```

### Attribute Assertions

Verify has the ability to test the value of object and static class properties (or "attributes"), even those that are protected or private. While writing assertions about a subject's internal state is not considered good practice, there are times when inspecting a protected value can be the simplest way of checking your code. The attribute you wish to check can be tacked on after calling `verify()`, just like if you were accessing it as a public value. For example, if you had an object called `$user` with a private `first_name` property that should be equal to `'Alice'`, you can assert that with the following code:

```php
verify($user)->first_name->is()->equalTo('Alice');
```

A similar assertion about a class's static properties might look like the following:

```php
verify(Model::class)->dbc->is()->resource();
```

All of Verify's code assertions should be compatible with reading object or class attributes.

If you would rather explicitly identify your attribute/property, you can do so with the `attributeNamed()` method:

```php
verify($obj)->attributeNamed('fooBar')->is()->equalTo(false);
```

### Assertion Modifiers

The behavior of many assertions can be tweaked inline with the test. These modifiers can be used to control case sensitivity, account for floating point errors, or strictness when checking for object identity and datatypes. They follow the naming convention of `with*()` and `without*()`. The available modifiers are:

```php
// Account for floating point errors
verify(0.1 + 0.2)->within(0.01)->is()->equalTo(0.3);

// Control case sensitivity when comparing strings
verify('A String')->withCase()->is()->equalTo('A String');
verify('A String')->withoutCase()->is()->equalTo('a string');

verify('A String')->withCase()->does()->contain('String');
verify('A String')->withoutCase()->will()->contain('string');

verify('A String')->withCase()->is()->equalToFile('/some/file.txt');
verify('a string')->withoutCase()->is()->equalToFile('/some/file.txt');

verify_file('/some/file.txt')->withCase()->is()->equalTo('/some/other/file.txt');
verify_file('/some/file.txt')->withoutCase()->is()->equalTo('/some/other/file.txt');

// Whether to check element ordering when comparing two arrays
verify([1, 2, 3])->withOrder()->is()->equalTo([1, 2, 3]);
verify([1, 2, 3])->withoutOrder()->is()->equalTo([3, 1, 2]);

// Whether to check for identity when comparing object values
verify([$objectA])->withIdentity()->will()->contain($objectA);
verify([$objectA])->withoutIdentity()->does()->contain($objectB);

// Whether to include type when comparing values
verify(['1', '2'])->withType()->does()->contain('1');
verify(['1', '2'])->withoutType()->will()->contain(1);

verify(['1', '2', '3'])->withType()->has()->subset(['1', '3']);
verify(['1', '2', '3'])->withoutType()->has()->subset([1, 3]);
// Note: subset() was deprecated in PHPUnit 8, and removed in version 9

// Whether to check element attributes when comparing XML documents
verify($domDocument)->withAttributes()->is()->equalToXmlStructure($validDocument);
verify($domDocument)->withoutAttributes()->is()->equalToXmlStructure($validDocument);
```

## Chaining Assertions

Assertions and conjunctions can be chained together, allowing developers to write multiple assertions about one subject very easily. For example:

```php
verify($value)->is()->internalType('array')
    ->and()->has()->key('my_index')
    ->and()->will()->contain('my value');
```

The above performs three separate assertions against `$value` in sequence, without having to redeclare our subject, and does so in a concise, easy to read syntax.

You can switch between positive and negative assertions on the fly--the condition will apply to whatever assertions follow the most recent conjunction. For example:

```php
verify($value)->will()->contain('value 1')
    ->and()->contain('value 2')
    ->and()->doesNot()->contain('value c')
    ->and()->doesNot()->contain('value d');
```

The above snippet will assert that `$value` contains `'value 1'` and `'value 2'`, and does *not* contain `'value c'` or `'value d'`. Notice that the second use of `doesNot()` is optional and was only included to aide in readability.

Chaining also applies to attributes and modifiers. The only exception is that once your chain contains an attribute, you can no longer add assertions about their containing object. Put another way, always write your assertions about an object *first* before writing any about its attributes. For example:

```php
verify($model)->isNot()->null()
    ->and()->is()->instanceOf('MyModelClass')
    ->and()->first_name->withCase()->is()->equalTo('Sally')
    ->and()->last_name->withoutCase()->doesNot()->contain('smith')
    ->and()->gpa->within(0.01)->is()->equalTo(4.0);
```
