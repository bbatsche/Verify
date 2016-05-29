<?php

require_once 'UnitTestBase.php';

class VerifyTest extends UnitTestBase
{
    public static function setUpBeforeClass()
    {
        static::$verifyMethod = 'verify';
    }

    public function testVerifyFunction()
    {
        $obj = verify('value');

        $this->assertAttributeEquals('value', 'actual', $obj);
        $this->assertAttributeEmpty('description', $obj);

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj);

        $obj = verify('message', 'value');

        $this->assertAttributeEquals('value', 'actual', $obj);
        $this->assertAttributeEquals('message', 'description', $obj);

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj);
    }

    public function testExpectFunctions()
    {
        $obj = expect('value');

        $this->assertAttributeEquals('value', 'actual', $obj);
        $this->assertAttributeEmpty('description', $obj);

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj);

        $obj = expect('message', 'value');

        $this->assertAttributeEquals('value', 'actual', $obj);
        $this->assertAttributeEquals('message', 'description', $obj);

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj);
    }

    public function testShortHandMethods()
    {
        $this->mockAssert->shouldReceive('assertNotEmpty')->with('subject', Mockery::any())->twice();
        $this->mockAssert->shouldReceive('assertEmpty')->with('subject', Mockery::any())->twice();

        $this->assertNull(verify_that('subject'));
        $this->assertNull(expect_that('subject'));
        $this->assertNull(verify_not('subject'));
        $this->assertNull(expect_not('subject'));
    }

    public function testEquals()
    {
        $this->fireTwoValueTest('equals', 'assertEquals');
        $this->fireTwoValueTest('doesNotEqual', 'assertNotEquals');
    }

    public function testContains()
    {
        $this->fireTwoValueTest('contains', 'assertContains');
        $this->fireTwoValueTest('doesNotContain', 'assertNotContains');
    }

    public function testRelativeInequality()
    {
        $this->fireTwoValueTest('isGreaterThan',      'assertGreaterThan');
        $this->fireTwoValueTest('isLessThan',         'assertLessThan');
        $this->fireTwoValueTest('isGreaterOrEqualTo', 'assertGreaterThanOrEqual');
        $this->fireTwoValueTest('isLessOrEqualTo',    'assertLessThanOrEqual');
    }

    public function testTrueFalseNullEmpty()
    {
        $this->fireSingleValueTest('isTrue',     'assertTrue');
        $this->fireSingleValueTest('isNotTrue',  'assertNotTrue');
        $this->fireSingleValueTest('isFalse',    'assertFalse');
        $this->fireSingleValueTest('isNotFalse', 'assertNotFalse');
        $this->fireSingleValueTest('isNull',     'assertNull');
        $this->fireSingleValueTest('isNotNull',  'assertNotNull');
        $this->fireSingleValueTest('isEmpty',    'assertEmpty');
        $this->fireSingleValueTest('isNotEmpty', 'assertNotEmpty');
    }

    public function testHasKey()
    {
        $this->fireTwoValueTest('hasKey',         'assertArrayHasKey');
        $this->fireTwoValueTest('doesNotHaveKey', 'assertArrayNotHasKey');
    }

    public function testInstanceOf()
    {
        $this->fireTwoValueTest('isInstanceOf',    'assertInstanceOf');
        $this->fireTwoValueTest('isNotInstanceOf', 'assertNotInstanceOf');
    }

    public function testInternalType()
    {
        $this->fireTwoValueTest('isInternalType',    'assertInternalType');
        $this->fireTwoValueTest('isNotInternalType', 'assertNotInternalType');
    }

    public function testHasAttribute()
    {
        $obj = new stdClass();

        $this->mockAssert->shouldReceive('assertClassHasAttribute')
            ->with('attribute1', 'ClassA', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertClassHasAttribute')
            ->with('attribute2', 'ClassB', 'message')->once();

        $this->mockAssert->shouldReceive('assertObjectHasAttribute')
            ->with('attribute3', $obj, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertObjectHasAttribute')
            ->with('attribute4', $obj, 'message')->once();

        $this->mockAssert->shouldReceive('assertClassNotHasAttribute')
            ->with('attribute5', 'ClassC', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertClassNotHasAttribute')
            ->with('attribute6', 'ClassD', 'message')->once();

        $this->mockAssert->shouldReceive('assertObjectNotHasAttribute')
            ->with('attribute7', $obj, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertObjectNotHasAttribute')
            ->with('attribute8', $obj, 'message')->once();

        $this->mockAssert->shouldReceive('assertClassHasStaticAttribute')
            ->with('attribute9', 'ClassE', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertClassHasStaticAttribute')
            ->with('attributeA', 'ClassF', 'message')->once();

        $this->mockAssert->shouldReceive('assertClassNotHasStaticAttribute')
            ->with('attributeB', 'ClassG', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertClassNotHasStaticAttribute')
            ->with('attributeC', 'ClassH', 'message')->once();

        $this->assertNull(verify('ClassA')->hasAttribute('attribute1'));
        $this->assertNull(verify('message', 'ClassB')->hasAttribute('attribute2'));

        $this->assertNull(verify($obj)->hasAttribute('attribute3'));
        $this->assertNull(verify('message', $obj)->hasAttribute('attribute4'));

        $this->assertNull(verify('ClassC')->doesNotHaveAttribute('attribute5'));
        $this->assertNull(verify('message', 'ClassD')->doesNotHaveAttribute('attribute6'));

        $this->assertNull(verify($obj)->doesNotHaveAttribute('attribute7'));
        $this->assertNull(verify('message', $obj)->doesNotHaveAttribute('attribute8'));

        $this->assertNull(verify('ClassE')->hasStaticAttribute('attribute9'));
        $this->assertNull(verify('message', 'ClassF')->hasStaticAttribute('attributeA'));

        $this->assertNull(verify('ClassG')->doesNotHaveStaticAttribute('attributeB'));
        $this->assertNull(verify('message', 'ClassH')->doesNotHaveStaticAttribute('attributeC'));
    }

    public function testContainsOnly()
    {
        $obj = new stdClass();

        $this->mockAssert->shouldReceive('assertContainsOnly')
            ->with('TypeA', $obj, null, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertContainsOnly')
            ->with('TypeB', $obj, null, 'message')->once();
        $this->mockAssert->shouldReceive('assertNotContainsOnly')
            ->with('TypeC', $obj, null, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertNotContainsOnly')
            ->with('TypeD', $obj, null, 'message')->once();

        $this->assertNull(verify($obj)->containsOnly('TypeA'));
        $this->assertNull(verify('message', $obj)->containsOnly('TypeB'));

        $this->assertNull(verify($obj)->doesNotContainOnly('TypeC'));
        $this->assertNull(verify('message', $obj)->doesNotContainOnly('TypeD'));
    }

    public function testCountAndSize()
    {
        $this->fireTwoValueTest('hasCount',         'assertCount');
        $this->fireTwoValueTest('doesNotHaveCount', 'assertNotCount');

        $this->fireTwoValueTest('sameSizeAs',    'assertSameSize');
        $this->fireTwoValueTest('notSameSizeAs', 'assertNotSameSize');
    }

    public function testJsonMethods()
    {
        $this->fireSingleValueTest('isJson', 'assertJson');

        $this->fireTwoValueTest('equalsJsonString',       'assertJsonStringEqualsJsonString');
        $this->fireTwoValueTest('doesNotEqualJsonString', 'assertJsonStringNotEqualsJsonString');

        $this->fireTwoValueTest('equalsJsonFile',       'assertJsonStringEqualsJsonFile');
        $this->fireTwoValueTest('doesNotEqualJsonFile', 'assertJsonStringNotEqualsJsonFile');
    }

    public function testRegExpFormats()
    {
        $this->fireTwoValueTest('matchesRegExp',      'assertRegExp');
        $this->fireTwoValueTest('doesNotMatchRegExp', 'assertNotRegExp');

        $this->fireTwoValueTest('matchesFormat',      'assertStringMatchesFormat');
        $this->fireTwoValueTest('doesNotMatchFormat', 'assertStringNotMatchesFormat');

        $this->fireTwoValueTest('matchesFormatFile',      'assertStringMatchesFormatFile');
        $this->fireTwoValueTest('doesNotMatchFormatFile', 'assertStringNotMatchesFormatFile');
    }

    public function testSame()
    {
        $this->fireTwoValueTest('sameAs',    'assertSame');
        $this->fireTwoValueTest('notSameAs', 'assertNotSame');
    }

    public function testStartsEndsWith()
    {
        $this->fireTwoValueTest('startsWith',       'assertStringStartsWith');
        $this->fireTwoValueTest('doesNotStartWith', 'assertStringStartsNotWith');

        $this->fireTwoValueTest('endsWith',       'assertStringEndsWith');
        $this->fireTwoValueTest('doesNotEndWith', 'assertStringEndsNotWith');
    }

    public function testEqualsFile()
    {
        $this->fireTwoValueTest('equalsFile',       'assertStringEqualsFile');
        $this->fireTwoValueTest('doesNotEqualFile', 'assertStringNotEqualsFile');
    }

    public function testXmlMethods()
    {
        $subject = new DOMDocument();
        $target  = new DOMDocument();

        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($target, $subject, false, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($target, $subject, false, 'message')->once();

        $this->assertNull(verify($subject)->equalsXmlStructure($target));
        $this->assertNull(verify('message', $subject)->equalsXmlStructure($target));

        $this->fireTwoValueTest('equalsXmlFile',       'assertXmlStringEqualsXmlFile');
        $this->fireTwoValueTest('doesNotEqualXmlFile', 'assertXmlStringNotEqualsXmlFile');

        $this->fireTwoValueTest('equalsXmlString',       'assertXmlStringEqualsXmlString');
        $this->fireTwoValueTest('doesNotEqualXmlString', 'assertXmlStringNotEqualsXmlString');
    }
}
