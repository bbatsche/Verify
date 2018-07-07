<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BeBat\Verify\VerifyDirectory;

class VerifyDirectoryTest extends UnitTestBase
{
    protected $defaultActualValue = 'directory under test';

    public function setUp()
    {
        $this->subject = new VerifyDirectory($this->defaultActualValue, 'some message');

        parent::setUp();
    }

    /**
     * All VerifyDirectory methods.
     *
     * @return array
     */
    public function allMethods(): array
    {
        return [
            ['exist'],
            ['readable'],
            ['writable'],
        ];
    }

    /**
     * All VerifyDirectory methods and their PHPUnit assertions that do not take a value for comparison.
     *
     * @return array
     */
    public function noParamMethods(): array
    {
        return [
            [true,  'exist',    'assertDirectoryExists'],
            [true,  'readable', 'assertDirectoryIsReadable'],
            [true,  'writable', 'assertDirectoryIsWritable'],
            [false, 'exist',    'assertDirectoryNotExists'],
            [false, 'readable', 'assertDirectoryNotIsReadable'],
            [false, 'writable', 'assertDirectoryNotIsWritable'],
        ];
    }

    /**
     * VerifyDirectory doesn't have any comparison methods so override parent test with a no-op.
     *
     * @param bool   $modifierCondition
     * @param string $verifyMethod
     * @param string $assertMethod
     * @param mixed  $expectedValue
     *
     * @doesNotPerformAssertions
     */
    public function testSingleParamMethods(
        bool $modifierCondition = true,
        string $verifyMethod = '',
        string $assertMethod = '',
        $expectedValue = 'some value'
    ) {
    }
}
