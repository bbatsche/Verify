<?php

require_once 'UnitTestBase.php';

class VerifyAttributeTest extends UnitTestBase
{
    public static function setUpBeforeClass()
    {
        static::$verifyMethod = 'verify';
    }

    public function testAttributeFunctions()
    {
        $obj1 = verify('value');

        $this->assertAttributeEmpty('attributeName', $obj1);

        $obj2 = verify('value')->attrMagicMethod;

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj2);
        $this->assertAttributeEquals('attrMagicMethod', 'attributeName', $obj2);

        $obj3 = verify('value')->attribute('attributeCall');

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj3);
        $this->assertAttributeEquals('attributeCall', 'attributeName', $obj3);
    }
}
