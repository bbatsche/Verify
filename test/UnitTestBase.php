<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BeBat\Verify\MissingConditionException;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use phpmock\mockery\PHPMockery;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

abstract class UnitTestBase extends TestCase
{
    use MockeryPHPUnitIntegration;
    use SetupMockeryTrait;

    /**
     * Default value used for Verify objects.
     *
     * @var string
     */
    protected $defaultActualValue;

    /**
     * Verify class.
     *
     * @var \BeBat\Verify\Verify|\BeBat\Verify\VerifyFile|\BeBat\Verify\VerifyDirectory
     */
    protected $subject;

    /**
     * Test MissingConditionException is thrown for all methods.
     *
     * @param mixed $value
     *
     * @dataProvider allMethods
     *
     * @return void
     */
    public function testMissingConditionException(string $verifyMethod, $value = 'dummy value')
    {
        $this->expectException(MissingConditionException::class);

        $this->subject->{$verifyMethod}($value);
    }

    /**
     * Test VerifyFile methods that don't take any value.
     *
     * @dataProvider noParamMethods
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testNoParamMethods(bool $modifierCondition, string $verifyMethod, string $assertMethod)
    {
        PHPMockery::mock('BeBat\\Verify', 'method_exists')->andReturn(true);

        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with($this->defaultActualValue, 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->{$verifyMethod}());
    }

    /**
     * Test verify methods that take in a single value for comparison.
     *
     * @param mixed $expectedValue
     *
     * @dataProvider singleParamMethods
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testSingleParamMethods(
        bool $modifierCondition,
        string $verifyMethod,
        string $assertMethod,
        $expectedValue = 'some value'
    ) {
        PHPMockery::mock('BeBat\\Verify', 'method_exists')->andReturn(true);

        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with($expectedValue, $this->defaultActualValue, 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->{$verifyMethod}($expectedValue));
    }

    /**
     * Inject $value into modifierCondition of subject.
     *
     * @return void
     */
    protected function setModifierCondition(bool $value)
    {
        $reflection       = new ReflectionObject($this->subject);
        $modifierProperty = $reflection->getProperty('modifierCondition');
        $modifierProperty->setAccessible(true);
        $modifierProperty->setValue($this->subject, $value);
        $modifierProperty->setAccessible(false);
    }
}
