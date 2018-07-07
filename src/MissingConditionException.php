<?php

declare(strict_types=1);

namespace BeBat\Verify;

class MissingConditionException extends \BadMethodCallException
{
    public function __construct(int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Assertions must be prefaced by some condition method, such as "is()", "will()", "doesNot()", "isNot()", etc.', $code, $previous);
    }
}
