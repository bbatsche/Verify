<?php

declare(strict_types=1);

require_once 'UnitTestBase.php';

use function BeBat\Verify\verify_file;

class VerifyFileTest extends UnitTestBase
{
    public static function setUpBeforeClass()
    {
        static::$verifyMethod = 'verify_file';
    }

    public function testEquals()
    {
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 1', 'subject 1', Mockery::any(), Mockery::any(), Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 2', 'subject 2', 'message', Mockery::any(), Mockery::any())->once();

        $this->assertNull(verify_file('subject 1')->equals('test 1'));
        $this->assertNull(verify_file('message', 'subject 2')->equals('test 2'));
    }

    public function testExists()
    {
        $this->fireSingleValueTest('exists', 'assertFileExists');
        $this->fireSingleValueTest('doesNotExist', 'assertFileNotExists');
    }

    public function testIgnoreCaseEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 1', 'subject 1', Mockery::any(), Mockery::any(), false)->once();
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 2', 'subject 2', 'message 2', Mockery::any(), false)->once();

        $this->assertNull(verify_file('subject 1')->equals('test 1'));
        $this->assertNull(verify_file('message 2', 'subject 2')->equals('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 3', 'subject 3', Mockery::any(), Mockery::any(), false)->once();
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 4', 'subject 4', 'message 4', Mockery::any(), false)->once();

        $this->assertNull(verify_file('subject 3')->withCase()->equals('test 3'));
        $this->assertNull(verify_file('message 4', 'subject 4')->withCase()->equals('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 5', 'subject 5', Mockery::any(), Mockery::any(), true)->once();
        $this->mockAssert->shouldReceive('assertFileEquals')
            ->with('test 6', 'subject 6', 'message 6', Mockery::any(), true)->once();

        $this->assertNull(verify_file('subject 5')->withoutCase()->equals('test 5'));
        $this->assertNull(verify_file('message 6', 'subject 6')->withoutCase()->equals('test 6'));
    }

    public function testIgnoreCaseNotEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 1', 'subject 1', Mockery::any(), Mockery::any(), false)->once();
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 2', 'subject 2', 'message 2', Mockery::any(), false)->once();

        $this->assertNull(verify_file('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify_file('message 2', 'subject 2')->doesNotEqual('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 3', 'subject 3', Mockery::any(), Mockery::any(), false)->once();
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 4', 'subject 4', 'message 4', Mockery::any(), false)->once();

        $this->assertNull(verify_file('subject 3')->withCase()->doesNotEqual('test 3'));
        $this->assertNull(verify_file('message 4', 'subject 4')->withCase()->doesNotEqual('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 5', 'subject 5', Mockery::any(), Mockery::any(), true)->once();
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 6', 'subject 6', 'message 6', Mockery::any(), true)->once();

        $this->assertNull(verify_file('subject 5')->withoutCase()->doesNotEqual('test 5'));
        $this->assertNull(verify_file('message 6', 'subject 6')->withoutCase()->doesNotEqual('test 6'));
    }

    public function testJsonFile()
    {
        $this->fireTwoValueTest('equalsJsonFile', 'assertJsonFileEqualsJsonFile');
        $this->fireTwoValueTest('doesNotEqualJsonFile', 'assertJsonFileNotEqualsJsonFile');
    }

    public function testNotEquals()
    {
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 1', 'subject 1', Mockery::any(), Mockery::any(), Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertFileNotEquals')
            ->with('test 2', 'subject 2', 'message', Mockery::any(), Mockery::any())->once();

        $this->assertNull(verify_file('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify_file('message', 'subject 2')->doesNotEqual('test 2'));
    }

    public function testVerifyFileFunction()
    {
        $obj = verify_file('filename');

        $this->assertAttributeSame('filename', 'actual', $obj);
        $this->assertAttributeEmpty('description', $obj);

        $this->assertInstanceOf('BeBat\\Verify\\VerifyFile', $obj);

        $obj = verify_file('message', 'filename');

        $this->assertAttributeSame('filename', 'actual', $obj);
        $this->assertAttributeSame('message', 'description', $obj);

        $this->assertInstanceOf('BeBat\\Verify\\VerifyFile', $obj);
    }

    public function testVerifyFileTooFewArgs()
    {
        $this->expectException('BadMethodCallException');
        verify_file();
    }

    public function testVerifyFileTooManyArgs()
    {
        $this->expectException('BadMethodCallException');
        verify_file('arg1', 'arg2', 'arg3');
    }

    public function testXmlFile()
    {
        $this->fireTwoValueTest('equalsXmlFile', 'assertXmlFileEqualsXmlFile');
        $this->fireTwoValueTest('doesNotEqualXmlFile', 'assertXmlFileNotEqualsXmlFile');
    }
}
