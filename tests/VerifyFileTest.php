<?php

require_once 'UnitTestBase.php';

class VerifyFileTest extends UnitTestBase
{
    public static function setUpBeforeClass()
    {
        static::$verifyMethod = 'verify_file';
    }

    public function testVerifyFileFunction()
    {
        $obj = verify_file('filename');

        $this->assertAttributeEquals('filename', 'actual', $obj);
        $this->assertAttributeEmpty('description', $obj);

        $this->assertInstanceOf('BeBat\Verify\VerifyFile', $obj);

        $obj = verify_file('message', 'filename');

        $this->assertAttributeEquals('filename', 'actual', $obj);
        $this->assertAttributeEquals('message', 'description', $obj);

        $this->assertInstanceOf('BeBat\Verify\VerifyFile', $obj);
    }

    public function testExpectFileFunction()
    {
        $obj = expect_file('filename');

        $this->assertAttributeEquals('filename', 'actual', $obj);
        $this->assertAttributeEmpty('description', $obj);

        $this->assertInstanceOf('BeBat\Verify\VerifyFile', $obj);

        $obj = expect_file('message', 'filename');

        $this->assertAttributeEquals('filename', 'actual', $obj);
        $this->assertAttributeEquals('message', 'description', $obj);

        $this->assertInstanceOf('BeBat\Verify\VerifyFile', $obj);
    }

    public function testEquals()
    {
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 1', 'subject 1', Mockery::any(), Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 2', 'subject 2', 'message', Mockery::any())->once();

        $this->assertNull(verify_file('subject 1')->equals('test 1'));
        $this->assertNull(verify_file('message', 'subject 2')->equals('test 2'));
    }

    public function testNotEquals()
    {
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 1', 'subject 1', Mockery::any(), Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 2', 'subject 2', 'message', Mockery::any())->once();

        $this->assertNull(verify_file('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify_file('message', 'subject 2')->doesNotEqual('test 2'));
    }

    public function testSortingEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 1', 'subject 1', Mockery::any(), false)->once();
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 2', 'subject 2', 'message 2', false)->once();

        $this->assertNull(verify_file('subject 1')->equals('test 1'));
        $this->assertNull(verify_file('message 2', 'subject 2')->equals('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 3', 'subject 3', Mockery::any(), false)->once();
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 4', 'subject 4', 'message 4', false)->once();

        $this->assertNull(verify_file('subject 3')->withSameOrder()->equals('test 3'));
        $this->assertNull(verify_file('message 4', 'subject 4')->withSameOrder()->equals('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 5', 'subject 5', Mockery::any(), true)->once();
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 6', 'subject 6', 'message 6', true)->once();

        $this->assertNull(verify_file('subject 5')->withAnyOrder()->equals('test 5'));
        $this->assertNull(verify_file('message 6', 'subject 6')->withAnyOrder()->equals('test 6'));
    }

    public function testSortingArraysNotEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 1', 'subject 1', Mockery::any(), false)->once();
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 2', 'subject 2', 'message 2', false)->once();

        $this->assertNull(verify_file('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify_file('message 2', 'subject 2')->doesNotEqual('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 3', 'subject 3', Mockery::any(), false)->once();
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 4', 'subject 4', 'message 4', false)->once();

        $this->assertNull(verify_file('subject 3')->withSameOrder()->doesNotEqual('test 3'));
        $this->assertNull(verify_file('message 4', 'subject 4')->withSameOrder()->doesNotEqual('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 5', 'subject 5', Mockery::any(), true)->once();
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 6', 'subject 6', 'message 6', true)->once();

        $this->assertNull(verify_file('subject 5')->withAnyOrder()->doesNotEqual('test 5'));
        $this->assertNull(verify_file('message 6', 'subject 6')->withAnyOrder()->doesNotEqual('test 6'));
    }

    public function testExists()
    {
        $this->fireSingleValueTest('exists',       'assertFileExists');
        $this->fireSingleValueTest('doesNotExist', 'assertFileNotExists');
    }

    public function testJsonFile()
    {
        $this->fireTwoValueTest('equalsJsonFile',       'assertJsonFileEqualsJsonFile');
        $this->fireTwoValueTest('doesNotEqualJsonFile', 'assertJsonFileNotEqualsJsonFile');
    }

    public function testXmlFile()
    {
        $this->fireTwoValueTest('equalsXmlFile',       'assertXmlFileEqualsXmlFile');
        $this->fireTwoValueTest('doesNotEqualXmlFile', 'assertXmlFileNotEqualsXmlFile');
    }
}
