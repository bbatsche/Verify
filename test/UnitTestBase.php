<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BeBat\Verify\Assert;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

abstract class UnitTestBase extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    protected $mockAssert;

    protected $subject;

    protected function setUp()
    {
        $this->mockAssert = Mockery::mock('alias:' . Assert::class);
    }
}
