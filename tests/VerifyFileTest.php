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
