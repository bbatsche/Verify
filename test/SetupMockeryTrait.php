<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BeBat\Verify\Assert;
use Mockery;

if (PHP_MINOR_VERSION >= 1) {
    trait SetupMockeryTrait
    {
        /**
         * Assertion mock.
         *
         * @var Assert|\Mockery\LegacyMockInterface
         */
        protected $mockAssert;

        protected function setUp(): void
        {
            $this->initSubject();

            $this->mockAssert = Mockery::mock('alias:' . Assert::class);
        }

        /**
         * Initialize the subject to be tested.
         *
         * @return void
         */
        abstract protected function initSubject();
    }
} else {
    trait SetupMockeryTrait
    {
        /**
         * Assertion mock.
         *
         * @var Assert|\Mockery\LegacyMockInterface
         */
        protected $mockAssert;

        /**
         * @return void
         */
        protected function setUp()
        {
            $this->initSubject();

            $this->mockAssert = Mockery::mock('alias:' . Assert::class);
        }

        /**
         * Initialize the subject to be tested.
         *
         * @return void
         */
        abstract protected function initSubject();
    }
}
