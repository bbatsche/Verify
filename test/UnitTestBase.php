<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BeBat\Verify\Assert;
use BeBat\Verify\MissingConditionException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

abstract class UnitTestBase extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Default value used for Verify objects.
     *
     * @var string
     */
    protected $defaultActualValue;

    /**
     * Assertion mock.
     *
     * @var Assert|\Mockery\MockInterface
     */
    protected $mockAssert;

    /**
     * Verify class.
     *
     * @var \BeBat\Verify\Verify|\BeBat\Verify\VerifyFile|\BeBat\Verify\VerifyDirectory
     */
    protected $subject;

    protected function setUp()
    {
        $this->mockAssert = Mockery::mock('alias:' . Assert::class);
    }

    /**
     * Test MissingConditionException is thrown for all methods.
     *
     * @param string $verifyMethod
     * @param mixed  $value
     *
     * @dataProvider allMethods
     */
    public function testMissingConditionException(string $verifyMethod, $value = 'dummy value')
    {
        $this->expectException(MissingConditionException::class);

        $this->subject->{$verifyMethod}($value);
    }

    /**
     * Test VerifyFile methods that don't take any value.
     *
     * @param bool   $modifierCondition
     * @param string $verifyMethod
     * @param string $assertMethod
     *
     * @dataProvider noParamMethods
     */
    public function testNoParamMethods(bool $modifierCondition, string $verifyMethod, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with($this->defaultActualValue, 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->{$verifyMethod}());
    }

    /**
     * Test verify methods that take in a single value for comparison.
     *
     * @param bool   $modifierCondition
     * @param string $verifyMethod
     * @param string $assertMethod
     * @param mixed  $expectedValue
     *
     * @dataProvider singleParamMethods
     */
    public function testSingleParamMethods(
        bool $modifierCondition,
        string $verifyMethod,
        string $assertMethod,
        $expectedValue = 'some value'
    ) {
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with($expectedValue, $this->defaultActualValue, 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->{$verifyMethod}($expectedValue));
    }

    protected function setModifierCondition(bool $value)
    {
        $reflection       = new \ReflectionObject($this->subject);
        $modifierProperty = $reflection->getProperty('modifierCondition');
        $modifierProperty->setAccessible(true);
        $modifierProperty->setValue($this->subject, $value);
        $modifierProperty->setAccessible(false);
    }
}
