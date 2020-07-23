<?php

declare(strict_types=1);

namespace BeBat\Verify;

use BeBat\Verify\Assert as a;

/**
 * Verify Directories.
 *
 * Collection of assertions specific to filesystem directories.
 */
class VerifyDirectory extends VerifyBase
{
    /**
     * Assert SUT does or does not exist in the filesystem.
     */
    public function exist(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertDirectoryExists($this->actual, $this->description);
        } else {
            a::assertDirectoryNotExists($this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT is or is not readable.
     */
    public function readable(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertDirectoryIsReadable($this->actual, $this->description);
        } else {
            a::assertDirectoryNotIsReadable($this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT is or is not writable.
     */
    public function writable(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertDirectoryIsWritable($this->actual, $this->description);
        } else {
            a::assertDirectoryNotIsWritable($this->actual, $this->description);
        }

        return $this;
    }
}
