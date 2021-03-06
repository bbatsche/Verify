<?php

declare(strict_types=1);

namespace BeBat\Verify;

/**
 * Assert Class.
 *
 * This class acts as a simple wrapper for PHPUnit_Framework_Assert. It
 * does not add any additional functionality, but it provides a point
 * where Mockery can inject itself so we can unit test API calls without
 * having to test full integration.
 *
 * @abstract
 */
abstract class Assert extends \PHPUnit\Framework\Assert
{
}
