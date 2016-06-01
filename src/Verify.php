<?php namespace BeBat\Verify;

use BeBat\Verify\Assert as a;

/**
 * Verify Class
 *
 * Bassic set of assertions
 *
 * @package BeBat\Verify
 * @uses \BeBat\Verify\Assert
 */
class Verify extends VerifyBase
{
    /**
     * Name of object attribute to evaluate (rather than the object itsefl)
     *
     * @var null|string
     */
    protected $attributeName;

     /**
     * Acceptable range when checking for floating point equality
     *
     * @var float
     */
    protected $floatDelta = 0.0;

    /**
     * Maximum depth when checking array equality
     *
     * PHPUnit does not use this value in any way, it's included here for consistency.
     * There is no exposed API for modifying this value.
     *
     * @var int
     */
    protected $maxDepth = 10;

    /**
     * Check for object identity when checking array contents in SUT
     *
     * @var bool
     */
    protected $objectIdentity = true;

    /**
     * Check internal datatype when checking SUT contents
     *
     * @var bool
     */
    protected $dataType = false;

    /**
     * Compare attributes when checking XML structure of SUT
     *
     * @var bool
     */
    protected $xmlAttributes = false;

    /**
     * Sets the attribute name to check
     *
     * @param string $attr Name of attribute
     * @return self
     */
    public function __get($attr)
    {
        return $this->attribute($attr);
    }

    /**
     * Sets the attribute name to check
     *
     * @param string $attr Name of attribute
     * @return self
     */
    public function attribute($attr)
    {
        $this->attributeName = $attr;

        return $this;
    }

    /**
     * Specify an acceptable range when checking a floating point SUT's equality
     *
     * @param float $delta range within which floating point values will be considered "equal"
     * @return self
     */
    public function within($delta)
    {
        $this->floatDelta = $delta;

        return $this;
    }

    /**
     * Include element ordering when comparing SUT to an array
     *
     * @return self
     */
    public function withOrder()
    {
        $this->ignoreOrder = false;

        return $this;
    }

    /**
     * Ignore element ordering when comparing SUT to an array
     *
     * @return self
     */
    public function withoutOrder()
    {
        $this->ignoreOrder = true;

        return $this;
    }

    /**
     * Compare objects within SUT based on their identity, not just value
     *
     * @return self
     */
    public function withIdentity()
    {
        $this->objectIdentity = true;

        return $this;
    }

    /**
     * Compare objects within SUT based solely on their value
     *
     * @return self
     */
    public function withoutIdentity()
    {
        $this->objectIdentity = false;

        return $this;
    }

    /**
     * Compare both type and value for elements in SUT
     *
     * @return self
     */
    public function withType()
    {
        $this->dataType = true;

        return $this;
    }

    /**
     * Ignore type when comparing elements in SUT
     *
     * @return self
     */
    public function withoutType()
    {
        $this->dataType = false;

        return $this;
    }

    /**
     * Check element attributes when comparing SUT to an XML document
     *
     * @return self
     */
    public function withAttributes()
    {
        $this->xmlAttributes = true;

        return $this;
    }

    /**
     * Ignore element attributes when comparing SUT to an XML document
     *
     * @return self
     */
    public function withoutAttributes()
    {
        $this->xmlAttributes = false;

        return $this;
    }

    /**
     * Assert SUT equals a given value
     *
     * @param mixed $expected Expected value for SUT
     * @return void
     */
    public function equals($expected)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeEquals(
                $expected,
                $this->attributeName,
                $this->actual,
                $this->description,
                $this->floatDelta,
                $this->maxDepth,
                $this->ignoreOrder,
                $this->ignoreCase
            );
        } else {
            a::assertEquals(
                $expected,
                $this->actual,
                $this->description,
                $this->floatDelta,
                $this->maxDepth,
                $this->ignoreOrder,
                $this->ignoreCase
            );
        }
    }

    /**
     * Assert SUT does not equal a given value
     *
     * @param mixed $expected Value SUT is expected to differ from
     * @return void
     */
    public function doesNotEqual($expected)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeNotEquals(
                $expected,
                $this->attributeName,
                $this->actual,
                $this->description,
                $this->floatDelta,
                $this->maxDepth,
                $this->ignoreOrder,
                $this->ignoreCase
            );
        } else {
            a::assertNotEquals(
                $expected,
                $this->actual,
                $this->description,
                $this->floatDelta,
                $this->maxDepth,
                $this->ignoreOrder,
                $this->ignoreCase
            );
        }
    }

    /**
     * Assert SUT contains a given value
     *
     * @param mixed $needle Value expected to be in SUT
     * @return void
     */
    public function contains($needle)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeContains(
                $needle,
                $this->attributeName,
                $this->actual,
                $this->description,
                $this->ignoreCase,
                $this->objectIdentity,
                $this->dataType
            );
        } else {
            a::assertContains(
                $needle,
                $this->actual,
                $this->description,
                $this->ignoreCase,
                $this->objectIdentity,
                $this->dataType
            );
        }
    }

    /**
     * Assert SUT does not contain a given value
     *
     * @param mixed $needle Value expected to be abscent from SUT
     * @return void
     */
    public function doesNotContain($needle)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeNotContains(
                $needle,
                $this->attributeName,
                $this->actual,
                $this->description,
                $this->ignoreCase,
                $this->objectIdentity,
                $this->dataType
            );
        } else {
            a::assertNotContains(
                $needle,
                $this->actual,
                $this->description,
                $this->ignoreCase,
                $this->objectIdentity,
                $this->dataType
            );
        }
    }

    /**
     * Assert SUT contains a given subset of values
     *
     * @param array $array Subset expected to be in SUT
     * @return void
     */
    public function hasSubset($array)
    {
        a::assertArraySubset($array, $this->actual, $this->dataType, $this->description);
    }

    /**
     * Assert SUT is greater than a given value
     *
     * @param int|float $expected Value SUT is expected to be greater than
     * @return void
     */
    public function isGreaterThan($expected)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeGreaterThan($expected, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertGreaterThan($expected, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT is less than a given value
     *
     * @param int|float $expected Value SUT is expected to be less than
     * @return void
     */
    public function isLessThan($expected)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeLessThan($expected, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertLessThan($expected, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT is greater than or equal to a given value
     *
     * @param int|float $expected Value SUT is expected to be greater than or equal to
     * @return void
     */
    public function isGreaterOrEqualTo($expected)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeGreaterThanOrEqual($expected, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertGreaterThanOrEqual($expected, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT is less than or equal to a given value
     *
     * @param int|float $expected Value SUT is expected to be less than or equal to
     * @return void
     */
    public function isLessOrEqualTo($expected)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeLessThanOrEqual($expected, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertLessThanOrEqual($expected, $this->actual, $this->description);
        }
    }

    /**
     * Assert that SUT is true
     *
     * @return void
     */
    public function isTrue()
    {
        a::assertTrue($this->actual, $this->description);
    }

    /**
     * Assert SUT is not true
     *
     * @return void
     */
    public function isNotTrue()
    {
        a::assertNotTrue($this->actual, $this->description);
    }

    /**
     * Assert SUT is false
     *
     * @return void
     */
    public function isFalse()
    {
        a::assertFalse($this->actual, $this->description);
    }

    /**
     * Assert SUT is not false
     *
     * @return void
     */
    public function isNotFalse()
    {
        a::assertNotFalse($this->actual, $this->description);
    }

    /**
     * Assert SUT is null
     *
     * @return void
     */
    public function isNull()
    {
        a::assertNull($this->actual, $this->description);
    }

    /**
     * Assert SUT is not null
     *
     * @return void
     */
    public function isNotNull()
    {
        a::assertNotNull($this->actual, $this->description);
    }

    /**
     * Assert SUT is empty
     *
     * @return void
     */
    public function isEmpty()
    {
        if (isset($this->attributeName)) {
            a::assertAttributeEmpty($this->attributeName, $this->actual, $this->description);
        } else {
            a::assertEmpty($this->actual, $this->description);
        }
    }

    /**
     * Assert SUT is not empty
     *
     * @return void
     */
    public function isNotEmpty()
    {
        if (isset($this->attributeName)) {
            a::assertAttributeNotEmpty($this->attributeName, $this->actual, $this->description);
        } else {
            a::assertNotEmpty($this->actual, $this->description);
        }
    }

    /**
     * Assert SUT has a given key
     *
     * @param int|string $key Key expected to be in SUT
     * @return void
     */
    public function hasKey($key)
    {
        a::assertArrayHasKey($key, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not have a given key
     *
     * @param int|string $key Key expected to be abscent from SUT
     * @return void
     */
    public function doesNotHaveKey($key)
    {
        a::assertArrayNotHasKey($key, $this->actual, $this->description);
    }

    /**
     * Assert SUT is an instance of a given class
     *
     * @param string $class Name of class SUT is expected to be an instance of
     * @return void
     */
    public function isInstanceOf($class)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeInstanceOf($class, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertInstanceOf($class, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT is not an instance of a given class
     *
     * @param string $class Name of class SUT is expect to not be
     * @return void
     */
    public function isNotInstanceOf($class)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeNotInstanceOf($class, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertNotInstanceOf($class, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT is a given PHP data type
     *
     * @param string $type Data type SUT is expected to be
     * @return void
     */
    public function isInternalType($type)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeInternalType($type, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertInternalType($type, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT is not a given PHP data type
     *
     * @param string $type Data type SUT is expected to not be
     * @return void
     */
    public function isNotInternalType($type)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeNotInternalType($type, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertNotInternalType($type, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT has a given class attribute
     *
     * @param string $attribute Name of attribute expected to be in SUT
     * @return void
     */
    public function hasAttribute($attribute)
    {
        if (is_string($this->actual)) {
            a::assertClassHasAttribute($attribute, $this->actual, $this->description);
        } else {
            a::assertObjectHasAttribute($attribute, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT does not have a given class attribute
     *
     * @param string $attribute Name of attribute expected to be abscent from SUT
     * @return void
     */
    public function doesNotHaveAttribute($attribute)
    {
        if (is_string($this->actual)) {
            a::assertClassNotHasAttribute($attribute, $this->actual, $this->description);
        } else {
            a::assertObjectNotHasAttribute($attribute, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT has a given static attribute
     *
     * @param string $attribute Name of attribute expected to be in SUT
     * @return void
     */
    public function hasStaticAttribute($attribute)
    {
        a::assertClassHasStaticAttribute($attribute, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not contain a given static attribute
     *
     * @param string $attribute Name of static attribute expected to be abscent from SUT
     * @return void
     */
    public function doesNotHaveStaticAttribute($attribute)
    {
        a::assertClassNotHasStaticAttribute($attribute, $this->actual, $this->description);
    }

    /**
     * Assert SUT contains only instances of a given class or internal PHP type
     *
     * @param string $type Class name or internal PHP type expected to be in SUT
     * @return void
     */
    public function containsOnly($type)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeContainsOnly($type, $this->attributeName, $this->actual, null, $this->description);
        } else {
            a::assertContainsOnly($type, $this->actual, null, $this->description);
        }
    }

    /**
     * Assert SUT does not contain just instances of a given class or internal PHP type
     *
     * This is frankly one of the odder assertions. Just to be clear, SUT *may* contain
     * instances of $type, so long as it *also* contains values of an additional type.
     *
     * @param string $type Class name or internal PHP type expected to not be the exclusive type in SUT
     * @return void
     */
    public function doesNotContainOnly($type)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeNotContainsOnly($type, $this->attributeName, $this->actual, null, $this->description);
        } else {
            a::assertNotContainsOnly($type, $this->actual, null, $this->description);
        }
    }

    /**
     * Assert SUT has a given number of elements
     *
     * @param int $count Expected number of elements to be in SUT
     * @return void
     */
    public function hasCount($count)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeCount($count, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertCount($count, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT does not have a given number of elements
     *
     * @param int $count Number of elements SUT is not expected to contain
     * @return void
     */
    public function doesNotHaveCount($count)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeNotCount($count, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertNotCount($count, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT has the same number of elements as given array (or `Countable` or `Traversable` objects)
     *
     * @param array|Countable|Traversable $expected Value SUT is expected to be the same size as
     * @return void
     */
    public function sameSizeAs($expected)
    {
        a::assertSameSize($expected, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not thave the same number of elements as a given array (or `Countable` or `Traversable` objects)
     *
     * @param array|Countable|Traversable $expected Value SUT is expected to have a different number of elements from
     * @return void
     */
    public function notSameSizeAs($expected)
    {
        a::assertNotSameSize($expected, $this->actual, $this->description);
    }

    /**
     * Assert SUT is a string containing valid JSON data
     *
     * @return void
     */
    public function isJson()
    {
        a::assertJson($this->actual, $this->description);
    }

    /**
     * Assert SUT's JSON value equals a given JSON value
     *
     * @param string $string JSON value SUT is expected to be equal to
     * @return void
     */
    public function equalsJsonString($string)
    {
        a::assertJsonStringEqualsJsonString($string, $this->actual, $this->description);
    }

    /**
     * Assert SUT's JSON value differs from a given JSON value
     *
     * @param string $string JSON value SUT is expected to be different from
     * @return void
     */
    public function doesNotEqualJsonString($string)
    {
        a::assertJsonStringNotEqualsJsonString($string, $this->actual, $this->description);
    }

    /**
     * Assert SUT's JSON value is the same as JSON in a given file
     *
     * @param string $file Name of file with JSON expected to match SUT
     * @return void
     */
    public function equalsJsonFile($file)
    {
        a::assertJsonStringEqualsJsonFile($file, $this->actual, $this->description);
    }

    /**
     * Assert SUT's JSON value is different from JSON stored in given file
     *
     * @param string $file Name of file with JSON SUT is epxected to be different from
     * @return void
     */
    public function doesNotEqualJsonFile($file)
    {
        a::assertJsonStringNotEqualsJsonFile($file, $this->actual, $this->description);
    }

    /**
     * Assert SUT matches a given regular expression
     *
     * @param string $expression Regular expression SUT is expected to match
     * @return void
     */
    public function matchesRegExp($expression)
    {
        a::assertRegExp($expression, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not match a given regular expression
     *
     * @param string $expression Regular expression SUT is exted to not match
     * @return void
     */
    public function doesNotMatchRegExp($expression)
    {
        a::assertNotRegExp($expression, $this->actual, $this->description);
    }

    /**
     * Assert SUT matches a given format
     *
     * @param string $format Format code(s) SUT is expected to match
     * @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertStringMatchesFormat
     * @return void
     */
    public function matchesFormat($format)
    {
        a::assertStringMatchesFormat($format, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not match a given format
     *
     * @param string $format Format code(s) SUT is exptected to differ from
     * @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertStringMatchesFormat
     * @return void
     */
    public function doesNotMatchFormat($format)
    {
        a::assertStringNotMatchesFormat($format, $this->actual, $this->description);
    }

    /**
     * Assert SUT matches a format stored in a given file
     *
     * @param string $formatFile Filename to read format code(s) from
     * @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertStringMatchesFormat
     * @return void
     */
    public function matchesFormatFile($formatFile)
    {
        a::assertStringMatchesFormatFile($formatFile, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not match a format stored in a given file
     *
     * @param string $formatFile Filename to read format code(s) from
     * @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertStringMatchesFormat
     * @return void
     */
    public function doesNotMatchFormatFile($formatFile)
    {
        a::assertStringNotMatchesFormatFile($formatFile, $this->actual, $this->description);
    }

    /**
     * Assert SUT has both the same value and type as a given value
     *
     * @param mixed $expected Value SUT is exptected to match
     * @return void
     */
    public function sameAs($expected)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeSame($expected, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertSame($expected, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT does not have the same value and type as a given value
     *
     * @param string $expected Value SUT is expected to differ from
     * @return void
     */
    public function notSameAs($expected)
    {
        if (isset($this->attributeName)) {
            a::assertAttributeNotSame($expected, $this->attributeName, $this->actual, $this->description);
        } else {
            a::assertNotSame($expected, $this->actual, $this->description);
        }
    }

    /**
     * Assert SUT starts with a given value
     *
     * @param string $prefix Value SUT is expected to start with
     * @return void
     */
    public function startsWith($prefix)
    {
        a::assertStringStartsWith($prefix, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not start with a given value
     *
     * @param string $prefix Value SUT is expected to not start with
     * @return void
     */
    public function doesNotStartWith($prefix)
    {
        a::assertStringStartsNotWith($prefix, $this->actual, $this->description);
    }

    /**
     * Assert SUT ends with a given value
     *
     * @param string $suffix Value SUT is expected to end with
     * @return void
     */
    public function endsWith($suffix)
    {
        a::assertStringEndsWith($suffix, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not end with a given value
     *
     * @param string $suffix Value SUT is expected to not end with
     * @return void
     */
    public function doesNotEndWith($suffix)
    {
        a::assertStringEndsNotWith($suffix, $this->actual, $this->description);
    }

    /**
     * Assert SUT equals the contents of a given file
     *
     * @param string $file Name of file SUT is expected to match
     * @return void
     */
    public function equalsFile($file)
    {
        // $canonicalize hardcoded to false
        a::assertStringEqualsFile($file, $this->actual, $this->description, false, $this->ignoreCase);
    }

    /**
     * Assert SUT does not equal the contents of a given file
     *
     * @param string $file Name of file SUT is expected to differ from
     * @return void
     */
    public function doesNotEqualFile($file)
    {
        // $canonicalize hardcoded to false
        a::assertStringNotEqualsFile($file, $this->actual, $this->description, false, $this->ignoreCase);
    }

    /**
     * Assert SUT has the same XML structur as a given DOMElement
     *
     * @param \DOMElement $xml Structure SUT is expected to match
     * @return void
     */
    public function equalsXmlStructure($xml)
    {
        a::assertEqualXMLStructure($xml, $this->actual, $this->xmlAttributes, $this->description);
    }

    /**
     * Assert SUT's XML value is equal to the XML stored in a given file
     *
     * @param string $file Name of XML file SUT is expected to match
     * @return void
     */
    public function equalsXmlFile($file)
    {
        a::assertXmlStringEqualsXmlFile($file, $this->actual, $this->description);
    }

    /**
     * Assert SUT's XML value differs from the XML stored in a given file
     *
     * @param string $file Name of XML file SUT is expected to differ from
     * @return void
     */
    public function doesNotEqualXmlFile($file)
    {
        a::assertXmlStringNotEqualsXmlFile($file, $this->actual, $this->description);
    }

    /**
     * Assert SUT's XML value is the same as a given string of XML
     *
     * @param string $xmlString XML data SUT is expected to equal
     * @return void
     */
    public function equalsXmlString($xmlString)
    {
        a::assertXmlStringEqualsXmlString($xmlString, $this->actual, $this->description);
    }

    /**
     * Assert SUT's XML value differs from a given string of XML
     *
     * @param string $xmlString XML data SUT is expected to differ from
     * @return void
     */
    public function doesNotEqualXmlString($xmlString)
    {
        a::assertXmlStringNotEqualsXmlString($xmlString, $this->actual, $this->description);
    }
}
