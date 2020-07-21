<?php

declare(strict_types=1);

namespace BeBat\Verify;

use BadMethodCallException;

/**
 * VerifyBase Class.
 *
 * Base class for other verify classes to inherit functionality from.
 * At this point, just the constructor and common properties to both.
 *
 * @abstract
 *
 * @method self and()
 * @method self be()
 * @method self does()
 * @method self doesNot()
 * @method self has()
 * @method self have()
 * @method self is()
 * @method self isNot()
 * @method self will()
 * @method self willNot()
 */
abstract class VerifyBase
{
    /** @var string[] */
    public static $negativeConjunctions = ['doesNot', 'isNot', 'willNot'];

    /** @var string[] */
    public static $neutralConjunctions = ['and', 'be', 'have'];

    /** @var string[] */
    public static $positiveConjunctions = ['does', 'has', 'is', 'will'];

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
     * Whether the condition we're asserting is positive or negative.
     *
     * @var bool
     */
    protected $modifierCondition;

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
     * Set positive or negative modifier and chain method calls along.
     *
     * @return static
     */
    public function __call(string $method, array $arguments = []): self
    {
        if (\in_array($method, self::$positiveConjunctions, true)) {
            $this->modifierCondition = true;

            return $this;
        }

        if (\in_array($method, self::$negativeConjunctions, true)) {
            $this->modifierCondition = false;

            return $this;
        }

        if (\in_array($method, self::$neutralConjunctions, true)) {
            return $this;
        }

        throw new BadMethodCallException("Unknown method {$method}.");
    }

    /**
     * Turn on case sensitivity when checking SUT.
     *
     * @return static
     */
    public function withCase(): self
    {
        $this->ignoreCase = false;

        return $this;
    }

    /**
     * Turn off case sensitivity when checking SUT.
     *
     * @return static
     */
    public function withoutCase(): self
    {
        $this->ignoreCase = true;

        return $this;
    }
}
