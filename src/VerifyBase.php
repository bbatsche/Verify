<?php

declare(strict_types=1);

namespace BeBat\Verify;

/**
 * VerifyBase Class.
 *
 * Base class for other verify classes to inherit functionality from.
 * At this point, just the constructor and common properties to both.
 *
 * @abstract
 */
abstract class VerifyBase
{
    /**
     * Actual value for Subject Under Test (SUT).
     *
     * @var mixed
     */
    protected $actual;

    /**
     * Description to be outputted if assertion fails.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Ignore case when checking SUT.
     *
     * @var bool
     */
    protected $ignoreCase = false;

    /**
     * Ignore element ordering when checking array values.
     *
     * @var bool
     */
    protected $ignoreOrder = false;

    /**
     * Constructor; shared between Verify and VerifyFile.
     *
     * @param mixed  $actual      Actual value for SUT
     * @param string $description Optional description if the assertion fails
     */
    public function __construct($actual, $description = '')
    {
        $this->actual      = $actual;
        $this->description = $description;
    }

    /**
     * Turn on case sensitivity when checking SUT.
     *
     * @return self
     */
    public function withCase()
    {
        $this->ignoreCase = false;

        return $this;
    }

    /**
     * Turn off case sensitivity when checking SUT.
     *
     * @return self
     */
    public function withoutCase()
    {
        $this->ignoreCase = true;

        return $this;
    }
}
