<?php

declare(strict_types=1);

namespace BeBat\Verify;

use BadMethodCallException;
use BeBat\Verify\Assert as a;
use Countable;
use DOMElement;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use Traversable;

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
     * Assert that SUT is or is not an array.
     */
    public function array(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsArray', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsArray($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotArray($this->getActualValue(), $this->description);
        }

        return $this;
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
                a::assertClassHasAttribute($attribute, $this->getActualValue(), $this->description);
            } else {
                a::assertObjectHasAttribute($attribute, $this->getActualValue(), $this->description);
            }
        } else {
            if (\is_string($this->actual)) {
                a::assertClassNotHasAttribute($attribute, $this->getActualValue(), $this->description);
            } else {
                a::assertObjectNotHasAttribute($attribute, $this->getActualValue(), $this->description);
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
     * Assert that SUT is or is not a boolean.
     */
    public function bool(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsBool', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsBool($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotBool($this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not callable.
     */
    public function callable(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsCallable', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsCallable($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotCallable($this->getActualValue(), $this->description);
        }

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

        $value = $this->getActualValue();

        if ($this->modifierCondition) {
            if (\is_string($value) && method_exists(a::class, 'assertStringContainsString')) {
                if ($this->ignoreCase) {
                    a::assertStringContainsStringIgnoringCase($needle, $value, $this->description);
                } else {
                    a::assertStringContainsString($needle, $value, $this->description);
                }
            } elseif (((\is_object($needle) && !$this->objectIdentity) || !$this->dataType) && method_exists(a::class, 'assertContainsEquals')) {
                a::assertContainsEquals($needle, $value, $this->description);
            } else {
                a::assertContains(
                    $needle,
                    $value,
                    $this->description,
                    $this->ignoreCase,
                    $this->objectIdentity,
                    $this->dataType
                );
            }
        } else {
            if (\is_string($value) && method_exists(a::class, 'assertStringNotContainsString')) {
                if ($this->ignoreCase) {
                    a::assertStringNotContainsStringIgnoringCase($needle, $value, $this->description);
                } else {
                    a::assertStringNotContainsString($needle, $value, $this->description);
                }
            } elseif (((\is_object($needle) && !$this->objectIdentity) || !$this->dataType) && method_exists(a::class, 'assertNotContainsEquals')) {
                a::assertNotContainsEquals($needle, $value, $this->description);
            } else {
                a::assertNotContains(
                    $needle,
                    $value,
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
            // $isNativeType can be determined automatically
            a::assertContainsOnly($type, $this->getActualValue(), null, $this->description);
        } else {
            // $isNativeType can be determined automatically
            a::assertNotContainsOnly($type, $this->getActualValue(), null, $this->description);
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
            a::assertCount($count, $this->getActualValue(), $this->description);
        } else {
            a::assertNotCount($count, $this->getActualValue(), $this->description);
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
            a::assertEmpty($this->getActualValue(), $this->description);
        } else {
            a::assertNotEmpty($this->getActualValue(), $this->description);
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
            a::assertStringEndsWith($suffix, $this->getActualValue(), $this->description);
        } else {
            a::assertStringEndsNotWith($suffix, $this->getActualValue(), $this->description);
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

        $value = $this->getActualValue();

        if ($this->modifierCondition) {
            if (
                is_numeric($value) &&
                $this->floatDelta !== 0.0 &&
                method_exists(a::class, 'assertEqualsWithDelta')
            ) {
                a::assertEqualsWithDelta($expected, $value, $this->floatDelta, $this->description);
            } elseif (
                (\is_array($value) || \is_object($value)) &&
                $this->ignoreOrder &&
                method_exists(a::class, 'assertEqualsCanonicalizing')
            ) {
                a::assertEqualsCanonicalizing($expected, $value, $this->description);
            } elseif (
                \is_string($value) &&
                $this->ignoreCase &&
                method_exists(a::class, 'assertEqualsIgnoringCase')
            ) {
                a::assertEqualsIgnoringCase($expected, $value, $this->description);
            } else {
                a::assertEquals(
                    $expected,
                    $value,
                    $this->description,
                    $this->floatDelta,
                    $this->maxDepth,
                    $this->ignoreOrder,
                    $this->ignoreCase
                );
            }
        } else {
            if (
                is_numeric($value) &&
                $this->floatDelta !== 0.0 &&
                method_exists(a::class, 'assertNotEqualsWithDelta')
            ) {
                a::assertNotEqualsWithDelta($expected, $value, $this->floatDelta, $this->description);
            } elseif (
                (\is_array($value) || \is_object($value)) &&
                $this->ignoreOrder &&
                method_exists(a::class, 'assertNotEqualsCanonicalizing')
            ) {
                a::assertNotEqualsCanonicalizing($expected, $value, $this->description);
            } elseif (
                \is_string($value) &&
                $this->ignoreCase &&
                method_exists(a::class, 'assertNotEqualsIgnoringCase')
            ) {
                a::assertNotEqualsIgnoringCase($expected, $value, $this->description);
            } else {
                a::assertNotEquals(
                    $expected,
                    $value,
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
            if ($this->ignoreCase && method_exists(a::class, 'assertStringEqualsFileIgnoringCase')) {
                a::assertStringEqualsFileIgnoringCase($file, $this->getActualValue(), $this->description);
            } else {
                // $canonicalize hardcoded to false
                a::assertStringEqualsFile($file, $this->getActualValue(), $this->description, false, $this->ignoreCase);
            }
        } else {
            if ($this->ignoreCase && method_exists(a::class, 'assertStringNotEqualsFileIgnoringCase')) {
                a::assertStringNotEqualsFileIgnoringCase($file, $this->getActualValue(), $this->description);
            } else {
                // $canonicalize hardcoded to false
                a::assertStringNotEqualsFile($file, $this->getActualValue(), $this->description, false, $this->ignoreCase);
            }
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
            a::assertJsonStringEqualsJsonFile($file, $this->getActualValue(), $this->description);
        } else {
            a::assertJsonStringNotEqualsJsonFile($file, $this->getActualValue(), $this->description);
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
            a::assertJsonStringEqualsJsonString($string, $this->getActualValue(), $this->description);
        } else {
            a::assertJsonStringNotEqualsJsonString($string, $this->getActualValue(), $this->description);
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
            a::assertXmlStringEqualsXmlFile($file, $this->getActualValue(), $this->description);
        } else {
            a::assertXmlStringNotEqualsXmlFile($file, $this->getActualValue(), $this->description);
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
            a::assertXmlStringEqualsXmlString($xmlString, $this->getActualValue(), $this->description);
        } else {
            a::assertXmlStringNotEqualsXmlString($xmlString, $this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT has the same XML structur as a given DOMElement.
     *
     * @param DOMElement $xml Structure SUT is expected to match
     */
    public function equalToXmlStructure(DOMElement $xml): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertEqualXMLStructure($xml, $this->getActualValue(), $this->xmlAttributes, $this->description);
        } else {
            throw new BadMethodCallException(__METHOD__ . ' does not support negative condition.');
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
            a::assertFalse($this->getActualValue(), $this->description);
        } else {
            a::assertNotFalse($this->getActualValue(), $this->description);
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
            a::assertFinite($this->getActualValue(), $this->description);
        } else {
            a::assertInfinite($this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not a float.
     */
    public function float(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsFloat', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsFloat($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotFloat($this->getActualValue(), $this->description);
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
            a::assertGreaterThanOrEqual($expected, $this->getActualValue(), $this->description);
        } else {
            a::assertLessThan($expected, $this->getActualValue(), $this->description);
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
            a::assertGreaterThan($expected, $this->getActualValue(), $this->description);
        } else {
            a::assertLessThanOrEqual($expected, $this->getActualValue(), $this->description);
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
            a::assertInfinite($this->getActualValue(), $this->description);
        } else {
            a::assertFinite($this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT is or is not an instance of a given class.
     *
     * @param class-string $class Name of class SUT is expected to be an instance of
     */
    public function instanceOf(string $class): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertInstanceOf($class, $this->getActualValue(), $this->description);
        } else {
            a::assertNotInstanceOf($class, $this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not an integer.
     */
    public function int(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsInt', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsInt($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotInt($this->getActualValue(), $this->description);
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

        $this->testForRemovedMethod('assertInternalType', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertInternalType($type, $this->getActualValue(), $this->description);
        } else {
            a::assertNotInternalType($type, $this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not iterable.
     */
    public function iterable(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsIterable', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsIterable($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotIterable($this->getActualValue(), $this->description);
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
            a::assertJson($this->getActualValue(), $this->description);
        } else {
            throw new BadMethodCallException(__METHOD__ . ' does not support negative condition.');
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
            a::assertArrayHasKey($key, $this->getActualValue(), $this->description);
        } else {
            a::assertArrayNotHasKey($key, $this->getActualValue(), $this->description);
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
            a::assertLessThanOrEqual($expected, $this->getActualValue(), $this->description);
        } else {
            a::assertGreaterThan($expected, $this->getActualValue(), $this->description);
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
            a::assertLessThan($expected, $this->getActualValue(), $this->description);
        } else {
            a::assertGreaterThanOrEqual($expected, $this->getActualValue(), $this->description);
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
            a::assertStringMatchesFormat($format, $this->getActualValue(), $this->description);
        } else {
            a::assertStringNotMatchesFormat($format, $this->getActualValue(), $this->description);
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
            a::assertStringMatchesFormatFile($formatFile, $this->getActualValue(), $this->description);
        } else {
            a::assertStringNotMatchesFormatFile($formatFile, $this->getActualValue(), $this->description);
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
            a::assertRegExp($expression, $this->getActualValue(), $this->description);
        } else {
            a::assertNotRegExp($expression, $this->getActualValue(), $this->description);
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
            a::assertNan($this->getActualValue(), $this->description);
        } else {
            throw new BadMethodCallException(__METHOD__ . ' does not support negative condition.');
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
            a::assertNull($this->getActualValue(), $this->description);
        } else {
            a::assertNotNull($this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not numeric.
     */
    public function numeric(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsNumeric', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsNumeric($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotNumeric($this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not an object.
     */
    public function object(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsObject', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsObject($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotObject($this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not a resource.
     */
    public function resource(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsResource', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsResource($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotResource($this->getActualValue(), $this->description);
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
            a::assertSame($expected, $this->getActualValue(), $this->description);
        } else {
            a::assertNotSame($expected, $this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT does or does not have the same number of elements as given array/Countable/Traversable object.
     *
     * @param array|Countable|Traversable $expected Value SUT is expected to be the same size as
     */
    public function sameSizeAs($expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertSameSize($expected, $this->getActualValue(), $this->description);
        } else {
            a::assertNotSameSize($expected, $this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not scalar.
     */
    public function scalar(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsScalar', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsScalar($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotScalar($this->getActualValue(), $this->description);
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
            a::assertStringStartsWith($prefix, $this->getActualValue(), $this->description);
        } else {
            a::assertStringStartsNotWith($prefix, $this->getActualValue(), $this->description);
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
            a::assertClassHasStaticAttribute($attribute, $this->getActualValue(), $this->description);
        } else {
            a::assertClassNotHasStaticAttribute($attribute, $this->getActualValue(), $this->description);
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not a string.
     */
    public function string(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        $this->testForUnimplementedMethod('assertIsString', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertIsString($this->getActualValue(), $this->description);
        } else {
            a::assertIsNotString($this->getActualValue(), $this->description);
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

        $this->testForRemovedMethod('assertArraySubset', __FUNCTION__);

        if ($this->modifierCondition) {
            a::assertArraySubset($array, $this->getActualValue(), $this->dataType, $this->description);
        } else {
            throw new BadMethodCallException(__METHOD__ . ' does not support negative condition.');
        }

        return $this;
    }

    /**
     * Assert that SUT is or is not true.
     */
    public function true(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertTrue($this->getActualValue(), $this->description);
        } else {
            a::assertNotTrue($this->getActualValue(), $this->description);
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

    /**
     * Get the value for an attribute (if specified) otherwise return the subject.
     *
     * @return mixed
     */
    private function getActualValue()
    {
        if (!$this->attributeName) {
            return $this->actual;
        }

        return $this->readAttribute();
    }

    /**
     * Returns the value of an object's attribute.
     * This also works for attributes that are declared protected or private.
     *
     * @throws InvalidAttributeException if subject doesn't have the named attribute
     *
     * @return mixed
     */
    private function getObjectAttribute()
    {
        $reflector = new ReflectionObject($this->actual);

        do {
            try {
                \assert(\is_string($this->attributeName));

                $attribute = $reflector->getProperty($this->attributeName);

                if (!$attribute || $attribute->isPublic()) {
                    return $this->actual->{$this->attributeName};
                }

                $attribute->setAccessible(true);
                $value = $attribute->getValue($this->actual);
                $attribute->setAccessible(false);

                return $value;
            } catch (ReflectionException $e) {
            }
        } while ($reflector = $reflector->getParentClass());

        throw new InvalidAttributeException("Could not find object property \"{$this->attributeName}\".");
    }

    /**
     * Returns the value of a static attribute.
     * This also works for attributes that are declared protected or private.
     *
     * @throws InvalidAttributeException if subject doesn't have the named static attribute
     *
     * @return mixed
     */
    private function getStaticAttribute()
    {
        $class = new ReflectionClass($this->actual);

        while ($class) {
            $attributes = $class->getStaticProperties();

            \assert(\is_string($this->attributeName));

            if (\array_key_exists($this->attributeName, $attributes)) {
                return $attributes[$this->attributeName];
            }

            $class = $class->getParentClass();
        }

        throw new InvalidAttributeException("Could not find static property \"{$this->attributeName}\".");
    }

    /**
     * Returns the value of an attribute of a class or an object.
     * This also works for attributes that are declared protected or private.
     *
     * @throws InvalidSubjectException if subject is not a class name or object
     *
     * @return mixed
     */
    private function readAttribute()
    {
        if (\is_string($this->actual)) {
            if (!class_exists($this->actual)) {
                throw new InvalidSubjectException("Could not find class \"{$this->actual}\".");
            }

            return $this->getStaticAttribute();
        }

        if (\is_object($this->actual)) {
            return $this->getObjectAttribute();
        }

        throw new InvalidSubjectException('Subject must be either an object or class name.');
    }

    /**
     * Test if a required PHPUnit method has been removed.
     *
     * @throws BadMethodCallException if the method is missing
     *
     * @return void
     */
    private function testForRemovedMethod(string $phpunitMethod, string $verifyMethod)
    {
        if (!method_exists(a::class, $phpunitMethod)) {
            throw new BadMethodCallException("The underlying method for {$verifyMethod}() has been removed. You should update your test accordingly.");
        }
    }

    /**
     * Test if a required PHPUnit method comes from a newer version.
     *
     * @throws BadMethodCallException if the method is missing
     *
     * @return void
     */
    private function testForUnimplementedMethod(string $phpunitMethod, string $verifyMethod)
    {
        if (!method_exists(a::class, $phpunitMethod)) {
            throw new BadMethodCallException("The underlying method for {$verifyMethod}() comes from a newer version of PHPUnit. You should update your project's dependencies.");
        }
    }
}
