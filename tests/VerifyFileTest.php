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

        $this->assertInstanceOf('BBat\Verify\VerifyFile', $obj);

        $obj = verify_file('message', 'filename');

        $this->assertAttributeEquals('filename', 'actual', $obj);
        $this->assertAttributeEquals('message', 'description', $obj);

        $this->assertInstanceOf('BBat\Verify\VerifyFile', $obj);
    }

    public function testExpectFileFunction()
    {
        $obj = expect_file('filename');

        $this->assertAttributeEquals('filename', 'actual', $obj);
        $this->assertAttributeEmpty('description', $obj);

        $this->assertInstanceOf('BBat\Verify\VerifyFile', $obj);

        $obj = expect_file('message', 'filename');

        $this->assertAttributeEquals('filename', 'actual', $obj);
        $this->assertAttributeEquals('message', 'description', $obj);

        $this->assertInstanceOf('BBat\Verify\VerifyFile', $obj);
    }

    public function testEquals()
    {
        $this->fireTwoValueTest('equals',       'assertFileEquals');
        $this->fireTwoValueTest('doesNotEqual', 'assertFileNotEquals');
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
