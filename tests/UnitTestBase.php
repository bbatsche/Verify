<?php

abstract class UnitTestBase extends PHPUnit_Framework_TestCase
{
    protected $mockAssert;
    protected static $verifyMethod;

    protected function setUp()
    {
        $this->mockAssert = Mockery::mock('alias:BeBat\Verify\Assert');
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    protected function fireSingleValueTest($verifyMethod, $assertMethod)
    {
        $verifyFunction = '\\BeBat\\Verify\\' . static::$verifyMethod;

        $this->mockAssert->shouldReceive($assertMethod)->with('subject 1', Mockery::any())->once();
        $this->mockAssert->shouldReceive($assertMethod)->with('subject 2', 'message')->once();

        $this->assertNull(call_user_func($verifyFunction, 'subject 1')->$verifyMethod());
        $this->assertNull(call_user_func($verifyFunction, 'message', 'subject 2')->$verifyMethod());
    }

    protected function fireTwoValueTest($verifyMethod, $assertMethod)
    {
        $verifyFunction = '\\BeBat\\Verify\\' . static::$verifyMethod;

        $this->mockAssert->shouldReceive($assertMethod)->with('test 1', 'subject 1', Mockery::any())->once();
        $this->mockAssert->shouldReceive($assertMethod)->with('test 2', 'subject 2', 'message')->once();

        $this->assertNull(call_user_func($verifyFunction, 'subject 1')->$verifyMethod('test 1'));
        $this->assertNull(call_user_func($verifyFunction, 'message', 'subject 2')->$verifyMethod('test 2'));
    }
}
