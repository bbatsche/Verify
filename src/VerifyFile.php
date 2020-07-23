<?php

declare(strict_types=1);

namespace BeBat\Verify;

use BeBat\Verify\Assert as a;

/**
 * Verify Files.
 *
 * Collection of assertions specific to filesystem objects.
 */
class VerifyFile extends VerifyBase
{
    /**
     * Assert contents of SUT are or are not equal to another given file's contents.
     *
     * @param string $expected Name of file SUT is expected to be equal to
     */
    public function equalTo(string $expected): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            if ($this->ignoreCase && method_exists(a::class, 'assertFileEqualsIgnoringCase')) {
                a::assertFileEqualsIgnoringCase($expected, $this->actual, $this->description);
            } else {
                // $canonicalize hard coded to false as it has no effect.
                a::assertFileEquals($expected, $this->actual, $this->description, false, $this->ignoreCase);
            }
        } else {
            if ($this->ignoreCase && method_exists(a::class, 'assertFileNotEqualsIgnoringCase')) {
                a::assertFileNotEqualsIgnoringCase($expected, $this->actual, $this->description);
            } else {
                // $canonicalize hard coded to false as it has no effect.
                a::assertFileNotEquals($expected, $this->actual, $this->description, false, $this->ignoreCase);
            }
        }

        return $this;
    }

    /**
     * Assert SUT's contents as JSON value are or are not equal to the JSON contents of a given file.
     *
     * @param string $file JSON file SUT is expected to be the same as
     */
    public function equalToJsonFile(string $file): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertJsonFileEqualsJsonFile($file, $this->actual, $this->description);
        } else {
            a::assertJsonFileNotEqualsJsonFile($file, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT's contents as XML are or are not the same as the XML in a given file.
     *
     * @param string $file XML file SUT is expected to be the same as
     */
    public function equalToXmlFile(string $file): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertXmlFileEqualsXmlFile($file, $this->actual, $this->description);
        } else {
            a::assertXmlFileNotEqualsXmlFile($file, $this->actual, $this->description);
        }

        return $this;
    }

    /**
     * Assert SUT does or does not exist in the filesystem.
     */
    public function exist(): self
    {
        if (!isset($this->modifierCondition)) {
            throw new MissingConditionException();
        }

        if ($this->modifierCondition) {
            a::assertFileExists($this->actual, $this->description);
        } else {
            a::assertFileNotExists($this->actual, $this->description);
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
            a::assertFileIsReadable($this->actual, $this->description);
        } else {
            a::assertFileNotIsReadable($this->actual, $this->description);
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
            a::assertFileIsWritable($this->actual, $this->description);
        } else {
            a::assertFileNotIsWritable($this->actual, $this->description);
        }

        return $this;
    }
}
