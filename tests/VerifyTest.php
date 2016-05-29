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
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->equals('test 1'));
        $this->assertNull(verify('message', 'subject 2')->equals('test 2'));
    }

    public function testNotEquals()
    {
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify('message', 'subject 2')->doesNotEqual('test 2'));
    }

    public function testFloatingPointEquals()
    {
        // Default: 0.0
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                0.0,
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                0.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->equals('test 2'));

        // Specified value: 1.0
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->within(1.0)->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->within(1.0)->equals('test 4'));
    }

    public function testFloatingPointNotEquals()
    {
        // Default: 0.0
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                0.0,
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                0.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotEqual('test 2'));

        // Specified value: 1.0
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->within(1.0)->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->within(1.0)->doesNotEqual('test 4'));
    }

    public function testSortingArraysEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                false,
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->equals('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->withSameOrder()->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withSameOrder()->equals('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->withAnyOrder()->equals('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withAnyOrder()->equals('test 6'));
    }

    public function testSortingArraysNotEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                false,
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotEqual('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->withSameOrder()->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withSameOrder()->doesNotEqual('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->withAnyOrder()->doesNotEqual('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withAnyOrder()->doesNotEqual('test 6'));
    }

    public function testIgnoreCaseEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->equals('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->withCase()->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withCase()->equals('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->withoutCase()->equals('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutCase()->equals('test 6'));
    }

    public function testIgnoreCaseNotEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotEqual('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->withCase()->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withCase()->doesNotEqual('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->withoutCase()->doesNotEqual('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutCase()->doesNotEqual('test 6'));
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
