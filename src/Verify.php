<?php namespace BBat\Verify;

use BBat\Verify\Asserts as a;

class Verify
{
    protected $actual = null;
    protected $description = '';

    public function __construct($description)
    {
        $descriptionGiven = (func_num_args() == 2);

        if (!$descriptionGiven) {
            $this->actual = $description;
        } else {
            $actual = func_get_args();
            $this->actual = $actual[1];
            $this->description = $description;
        }
    }

    public function equals($expected)
    {
        a::assertEquals($expected, $this->actual, $this->description);
    }

    public function doesNotEqual($expected)
    {
        a::assertNotEquals($expected, $this->actual, $this->description);
    }

    public function contains($needle)
    {
        a::assertContains($needle, $this->actual, $this->description);
    }

    public function doesNotContain($needle)
    {
        a::assertNotContains($needle, $this->actual, $this->description);
    }

    public function isGreaterThan($expected)
    {
        a::assertGreaterThan($expected, $this->actual, $this->description);
    }

    public function isLessThan($expected)
    {
        a::assertLessThan($expected, $this->actual, $this->description);
    }

    public function isGreaterOrEqualTo($expected)
    {
        a::assertGreaterThanOrEqual($expected, $this->actual, $this->description);
    }

    public function isLessOrEqualTo($expected)
    {
        a::assertLessThanOrEqual($expected, $this->actual, $this->description);
    }

    public function isTrue()
    {
        a::assertTrue($this->actual, $this->description);
    }

    public function isNotTrue()
    {
        a::assertNotTrue($this->actual, $this->description);
    }

    public function isFalse()
    {
        a::assertFalse($this->actual, $this->description);
    }

    public function isNotFalse()
    {
        a::assertNotFalse($this->actual, $this->description);
    }

    public function isNull()
    {
        a::assertNull($this->actual, $this->description);
    }

    public function isNotNull()
    {
        a::assertNotNull($this->actual, $this->description);
    }

    public function isEmpty()
    {
        a::assertEmpty($this->actual, $this->description);
    }

    public function isNotEmpty()
    {
        a::assertNotEmpty($this->actual, $this->description);
    }

    public function hasKey($key)
    {
        a::assertArrayHasKey($key, $this->actual, $this->description);
    }

    public function doesNotHaveKey($key)
    {
        a::assertArrayNotHasKey($key, $this->actual, $this->description);
    }

    public function isInstanceOf($class)
    {
        a::assertInstanceOf($class, $this->actual, $this->description);
    }

    public function isNotInstanceOf($class)
    {
        a::assertNotInstanceOf($class, $this->actual, $this->description);
    }

    public function isInternalType($type)
    {
        a::assertInternalType($type, $this->actual, $this->description);
    }

    public function isNotInternalType($type)
    {
        a::assertNotInternalType($type, $this->actual, $this->description);
    }

    public function hasAttribute($attribute)
    {
        if (is_string($this->actual)) {
            a::assertClassHasAttribute($attribute, $this->actual, $this->description);
        } else {
            a::assertObjectHasAttribute($attribute, $this->actual, $this->description);
        }
    }

    public function doesNotHaveAttribute($attribute)
    {
        if (is_string($this->actual)) {
            a::assertClassNotHasAttribute($attribute, $this->actual, $this->description);
        } else {
            a::assertObjectNotHasAttribute($attribute, $this->actual, $this->description);
        }
    }

    public function hasStaticAttribute($attribute)
    {
        a::assertClassHasStaticAttribute($attribute, $this->actual, $this->description);
    }

    public function doesNotHaveStaticAttribute($attribute)
    {
        a::assertClassNotHasStaticAttribute($attribute, $this->actual, $this->description);
    }

    public function containsOnly($type)
    {
        a::assertContainsOnly($type, $this->actual, null, $this->description);
    }

    public function doesNotContainOnly($type)
    {
        a::assertNotContainsOnly($type, $this->actual, null, $this->description);
    }

    public function hasCount($count)
    {
        a::assertCount($count, $this->actual, $this->description);
    }

    public function doesNotHaveCount($count)
    {
        a::assertNotCount($count, $this->actual, $this->description);
    }

    public function sameSizeAs($expected)
    {
        a::assertSameSize($expected, $this->actual, $this->description);
    }

    public function notSameSizeAs($expected)
    {
        a::assertNotSameSize($expected, $this->actual, $this->description);
    }

    public function isJson()
    {
        a::assertJson($this->actual, $this->description);
    }

    public function equalsJsonString($string)
    {
        a::assertJsonStringEqualsJsonString($string, $this->actual, $this->description);
    }

    public function doesNotEqualJsonString($string)
    {
        a::assertJsonStringNotEqualsJsonString($string, $this->actual, $this->description);
    }

    public function equalsJsonFile($file)
    {
        a::assertJsonStringEqualsJsonFile($file, $this->actual, $this->description);
    }

    public function doesNotEqualJsonFile($file)
    {
        a::assertJsonStringNotEqualsJsonFile($file, $this->actual, $this->description);
    }

    public function matchesRegExp($expression)
    {
        a::assertRegExp($expression, $this->actual, $this->description);
    }

    public function doesNotMatchRegExp($expression)
    {
        a::assertNotRegExp($expression, $this->actual, $this->description);
    }

    public function matchesFormat($format)
    {
        a::assertStringMatchesFormat($format, $this->actual, $this->description);
    }

    public function doesNotMatchFormat($format)
    {
        a::assertStringNotMatchesFormat($format, $this->actual, $this->description);
    }

    public function matchesFormatFile($formatFile)
    {
        a::assertStringMatchesFormatFile($formatFile, $this->actual, $this->description);
    }

    public function doesNotMatchFormatFile($formatFile)
    {
        a::assertStringNotMatchesFormatFile($formatFile, $this->actual, $this->description);
    }

    public function sameAs($expected)
    {
        a::assertSame($expected, $this->actual, $this->description);
    }

    public function notSameAs($expected)
    {
        a::assertNotSame($expected, $this->actual, $this->description);
    }

    public function startsWith($prefix)
    {
        a::assertStringStartsWith($prefix, $this->actual, $this->description);
    }

    public function doesNotStartWith($prefix)
    {
        a::assertStringStartsNotWith($prefix, $this->actual, $this->description);
    }

    public function endsWith($suffix)
    {
        a::assertStringEndsWith($suffix, $this->actual, $this->description);
    }

    public function doesNotEndWith($suffix)
    {
        a::assertStringEndsNotWith($suffix, $this->actual, $this->description);
    }

    public function equalsFile($file)
    {
        a::assertStringEqualsFile($file, $this->actual, $this->description);
    }

    public function doesNotEqualFile($file)
    {
        a::assertStringNotEqualsFile($file, $this->actual, $this->description);
    }

    public function equalsXmlStructure($xml)
    {
        a::assertEqualXMLStructure($xml, $this->actual, false, $this->description);
    }

    public function equalsXmlFile($file)
    {
        a::assertXmlStringEqualsXmlFile($file, $this->actual, $this->description);
    }

    public function doesNotEqualXmlFile($file)
    {
        a::assertXmlStringNotEqualsXmlFile($file, $this->actual, $this->description);
    }

    public function equalsXmlString($xmlString)
    {
        a::assertXmlStringEqualsXmlString($xmlString, $this->actual, $this->description);
    }

    public function doesNotEqualXmlString($xmlString)
    {
        a::assertXmlStringNotEqualsXmlString($xmlString, $this->actual, $this->description);
    }
}
