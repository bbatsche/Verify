<?php

declare(strict_types=1);

namespace BeBat\Verify;

use BeBat\Verify\Assert as a;

/**
 * Verify Class.
 *
 * Bassic set of assertions
 *
 * @uses \BeBat\Verify\Assert
 */
class Verify extends VerifyBase
{
    /**
     * Name of object attribute to evaluate (rather than the object itsefl).
     *
     * @var string|null
     */
    protected $attributeName;

    /**
     * Check internal datatype when checking SUT contents.
     *
     * @var bool
     */
    protected $dataType = false;

    /**
     * Acceptable range when checking for floating point equality.
     *
     * @var float
     */
    protected $floatDelta = 0.0;

    /**
     * Ignore element ordering when checking array values.
     *
     * @var bool
     */
    protected $ignoreOrder = false;

    /**
     * Maximum depth when checking array equality.
     *
     * PHPUnit does not use this value in any way, it's included here for consistency.
     * There is no exposed API for modifying this value.
     *
     * @var int
     */
    protected $maxDepth = 10;

    /**
     * Check for object identity when checking array contents in SUT.
     *
     * @var bool
     */
    protected $objectIdentity = true;

    /**
     * Compare attributes when checking XML structure of SUT.
     *
     * @var bool
     */
    protected $xmlAttributes = false;

    /**
     * Sets the attribute name to check.
     *
     * @param string $attr Name of attribute
     */
    public function __get(string $attr): self
    {
        return $this->attributeNamed($attr);
    }

    /**
     * Assert SUT does or does not have a given class attribute.
     *
     * @param string $attribute Name of attribute expected to be in SUT
     */
    public function attribute(string $attribute): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (\is_string($this->actual)) {
                a::assertClassHasAttribute($attribute, $this->actual, $this->description);
            } else {
                a::assertObjectHasAttribute($attribute, $this->actual, $this->description);
            }
        } else {
            if (\is_string($this->actual)) {
                a::assertClassNotHasAttribute($attribute, $this->actual, $this->description);
            } else {
                a::assertObjectNotHasAttribute($attribute, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Sets the attribute name to check.
     *
     * @param string $attr Name of attribute
     */
    public function attributeNamed(string $attr): self
    {
        $this->attributeName = $attr;

        return $this;
    }

    /**
     * Assert SUT does or does not contain a given value.
     *
     * @param mixed $needle Value expected to be in SUT
     */
    public function contain($needle): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
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
        } else {
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

        return $this;
    }

    /**
     * Assert SUT does or does not contain only instances of a given class or internal PHP type.
     *
     * @param string $type Class name or internal PHP type expected to be in SUT
     */
    public function containOnly(string $type): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                // $isNativeType can be determined automatically
                a::assertAttributeContainsOnly($type, $this->attributeName, $this->actual, null, $this->description);
            } else {
                // $isNativeType can be determined automatically
                a::assertContainsOnly($type, $this->actual, null, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                // $isNativeType can be determined automatically
                a::assertAttributeNotContainsOnly($type, $this->attributeName, $this->actual, null, $this->description);
            } else {
                // $isNativeType can be determined automatically
                a::assertNotContainsOnly($type, $this->actual, null, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT does or does not have a given number of elements.
     *
     * @param int $count Expected number of elements to be in SUT
     *
     * @return self
     */
    public function count(int $count)
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeCount($count, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertCount($count, $this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeNotCount($count, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertNotCount($count, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT is or is not empty.
     */
    public function empty(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeEmpty($this->attributeName, $this->actual, $this->description);
            } else {
                a::assertEmpty($this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeNotEmpty($this->attributeName, $this->actual, $this->description);
            } else {
                a::assertNotEmpty($this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT does or does not end with a given value.
     *
     * @param string $suffix Value SUT is expected to end with
     */
    public function endWith(string $suffix): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertStringEndsWith($suffix, $this->actual, $this->description);
        } else {
            a::assertStringEndsNotWith($suffix, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT does or does not equal a given value.
     *
     * @param mixed $expected Expected value for SUT
     */
    public function equalTo($expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
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
        } else {
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

        return $this;
    }

    /**
     * Assert SUT does or does not equal the contents of a given file.
     *
     * @param string $file Name of file SUT is expected to match
     */
    public function equalToFile(string $file): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            // $canonicalize hardcoded to false
            a::assertStringEqualsFile($file, $this->actual, $this->description, false, $this->ignoreCase);
        } else {
            // $canonicalize hardcoded to false
            a::assertStringNotEqualsFile($file, $this->actual, $this->description, false, $this->ignoreCase);
        }

        return $this;
    }

    /**
     * Assert SUT's JSON value is or is not the same as JSON in a given file.
     *
     * @param string $file Name of file with JSON expected to match SUT
     */
    public function equalToJsonFile(string $file): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertJsonStringEqualsJsonFile($file, $this->actual, $this->description);
        } else {
            a::assertJsonStringNotEqualsJsonFile($file, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT's JSON value does or does not equal a given JSON value.
     *
     * @param string $string JSON value SUT is expected to be equal to
     */
    public function equalToJsonString(string $string): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertJsonStringEqualsJsonString($string, $this->actual, $this->description);
        } else {
            a::assertJsonStringNotEqualsJsonString($string, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT's XML value is or is not equal to the XML stored in a given file.
     *
     * @param string $file Name of XML file SUT is expected to match
     */
    public function equalToXmlFile(string $file): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertXmlStringEqualsXmlFile($file, $this->actual, $this->description);
        } else {
            a::assertXmlStringNotEqualsXmlFile($file, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT's XML value is or is not the same as a given string of XML.
     *
     * @param string $xmlString XML data SUT is expected to equal
     */
    public function equalToXmlString(string $xmlString): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertXmlStringEqualsXmlString($xmlString, $this->actual, $this->description);
        } else {
            a::assertXmlStringNotEqualsXmlString($xmlString, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT has the same XML structur as a given DOMElement.
     *
     * @param \DOMElement $xml Structure SUT is expected to match
     */
    public function equalToXmlStructure(\DOMElement $xml): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertEqualXMLStructure($xml, $this->actual, $this->xmlAttributes, $this->description);
        } else {
            throw new \BadMethodCallException(__METHOD__ . ' does not support negative condition.');
        }

        return $this;
    }

    /**
     * Assert SUT is or is not false.
     */
    public function false(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertFalse($this->actual, $this->description);
        } else {
            a::assertNotFalse($this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT is or is not finite.
     */
    public function finite(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertFinite($this->actual, $this->description);
        } else {
            a::assertInfinite($this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT is or is not greater than or equal to a given value.
     *
     * @param int|float $expected Value SUT is expected to be greater than or equal to
     */
    public function greaterOrEqualTo($expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeGreaterThanOrEqual($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertGreaterThanOrEqual($expected, $this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeLessThan($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertLessThan($expected, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT is or is not greater than a given value.
     *
     * @param int|float $expected Value SUT is expected to be greater than
     */
    public function greaterThan($expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeGreaterThan($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertGreaterThan($expected, $this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeLessThanOrEqual($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertLessThanOrEqual($expected, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT is or is not infinite.
     */
    public function infinite(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertInfinite($this->actual, $this->description);
        } else {
            a::assertFinite($this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT is or is not an instance of a given class.
     *
     * @param string $class Name of class SUT is expected to be an instance of
     */
    public function instanceOf(string $class): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeInstanceOf($class, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertInstanceOf($class, $this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeNotInstanceOf($class, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertNotInstanceOf($class, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT is or is not a given PHP data type.
     *
     * @param string $type Data type SUT is expected to be
     */
    public function internalType(string $type): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeInternalType($type, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertInternalType($type, $this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeNotInternalType($type, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertNotInternalType($type, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT is or is not a string containing valid JSON data.
     */
    public function json(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertJson($this->actual, $this->description);
        } else {
            throw new \BadMethodCallException(__METHOD__ . ' does not support negative condition.');
        }

        return $this;
    }

    /**
     * Assert SUT does or does not have a given key.
     *
     * @param int|string $key Key expected to be in SUT
     */
    public function key($key): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertArrayHasKey($key, $this->actual, $this->description);
        } else {
            a::assertArrayNotHasKey($key, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT is or is not less than or equal to a given value.
     *
     * @param int|float $expected Value SUT is expected to be less than or equal to
     */
    public function lessOrEqualTo($expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeLessThanOrEqual($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertLessThanOrEqual($expected, $this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeGreaterThan($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertGreaterThan($expected, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT is or is not less than a given value.
     *
     * @param int|float $expected Value SUT is expected to be less than
     */
    public function lessThan($expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeLessThan($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertLessThan($expected, $this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeGreaterThanOrEqual($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertGreaterThanOrEqual($expected, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT does or does not match a given format.
     *
     * @param string $format Format code(s) SUT is expected to match
     *
     * @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertStringMatchesFormat
     */
    public function matchFormat(string $format): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertStringMatchesFormat($format, $this->actual, $this->description);
        } else {
            a::assertStringNotMatchesFormat($format, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT does or does not match a format stored in a given file.
     *
     * @param string $formatFile Filename to read format code(s) from
     *
     * @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertStringMatchesFormat
     */
    public function matchFormatFile(string $formatFile): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertStringMatchesFormatFile($formatFile, $this->actual, $this->description);
        } else {
            a::assertStringNotMatchesFormatFile($formatFile, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT does or does not match a given regular expression.
     *
     * @param string $expression Regular expression SUT is expected to match
     */
    public function matchRegExp(string $expression): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertRegExp($expression, $this->actual, $this->description);
        } else {
            a::assertNotRegExp($expression, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT is NaN.
     */
    public function nan(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertNan($this->actual, $this->description);
        } else {
            throw new \BadMethodCallException(__METHOD__ . ' does not support negative condition.');
        }

        return $this;
    }

    /**
     * Assert SUT is or is not null.
     */
    public function null(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertNull($this->actual, $this->description);
        } else {
            a::assertNotNull($this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT does or does not have both the same value and type as a given value.
     *
     * @param mixed $expected Value SUT is exptected to match
     */
    public function sameAs($expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if (isset($this->attributeName)) {
                a::assertAttributeSame($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertSame($expected, $this->actual, $this->description);
            }
        } else {
            if (isset($this->attributeName)) {
                a::assertAttributeNotSame($expected, $this->attributeName, $this->actual, $this->description);
            } else {
                a::assertNotSame($expected, $this->actual, $this->description);
            }
        }

        return $this;
    }

    /**
     * Assert SUT does or does not have the same number of elements as given array/Countable/Traversable object.
     *
     * @param array|\Countable|\Traversable $expected Value SUT is expected to be the same size as
     */
    public function sameSizeAs($expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertSameSize($expected, $this->actual, $this->description);
        } else {
            a::assertNotSameSize($expected, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT does or does not start with a given value.
     *
     * @param string $prefix Value SUT is expected to start with
     */
    public function startWith(string $prefix): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertStringStartsWith($prefix, $this->actual, $this->description);
        } else {
            a::assertStringStartsNotWith($prefix, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT does or does not have a given static attribute.
     *
     * @param string $attribute Name of attribute expected to be in SUT
     */
    public function staticAttribute(string $attribute): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertClassHasStaticAttribute($attribute, $this->actual, $this->description);
        } else {
            a::assertClassNotHasStaticAttribute($attribute, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT contains a given subset of values.
     *
     * @param array $array Subset expected to be in SUT
     */
    public function subset($array): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertArraySubset($array, $this->actual, $this->dataType, $this->description);
        } else {
            throw new \BadMethodCallException(__METHOD__ . ' does not support negative condition.');
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not true.
     *
     * return self
     */
    public function true(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertTrue($this->actual, $this->description);
        } else {
            a::assertNotTrue($this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Check element attributes when comparing SUT to an XML document.
     */
    public function withAttributes(): self
    {
        $this->xmlAttributes = true;

        return $this;
    }

    /**
     * Compare objects within SUT based on their identity, not just value.
     */
    public function withIdentity(): self
    {
        $this->objectIdentity = true;

        return $this;
    }

    /**
     * Specify an acceptable range when checking a floating point SUT's equality.
     *
     * @param float $delta range within which floating point values will be considered "equal"
     */
    public function within(float $delta): self
    {
        $this->floatDelta = $delta;

        return $this;
    }

    /**
     * Include element ordering when comparing SUT to an array.
     */
    public function withOrder(): self
    {
        $this->ignoreOrder = false;

        return $this;
    }

    /**
     * Ignore element attributes when comparing SUT to an XML document.
     */
    public function withoutAttributes(): self
    {
        $this->xmlAttributes = false;

        return $this;
    }

    /**
     * Compare objects within SUT based solely on their value.
     */
    public function withoutIdentity(): self
    {
        $this->objectIdentity = false;

        return $this;
    }

    /**
     * Ignore element ordering when comparing SUT to an array.
     */
    public function withoutOrder(): self
    {
        $this->ignoreOrder = true;

        return $this;
    }

    /**
     * Ignore type when comparing elements in SUT.
     */
    public function withoutType(): self
    {
        $this->dataType = false;

        return $this;
    }

    /**
     * Compare both type and value for elements in SUT.
     */
    public function withType(): self
    {
        $this->dataType = true;

        return $this;
    }
}
