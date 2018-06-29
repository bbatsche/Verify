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
     * Assert contents of SUT are not the same as another given file.
     *
     * @param string $expected Name of file SUT is expected to differ from
     */
    public function doesNotEqual($expected)
    {
        a::assertFileNotEquals($expected, $this->actual, $this->description, $this->ignoreOrder, $this->ignoreCase);
    }

    /**
     * Assert SUT's contents as a JSON value are not the same as the JSON contents of a given file.
     *
     * @param string $file JSON file SUT is expected to differ from
     */
    public function doesNotEqualJsonFile($file)
    {
        a::assertJsonFileNotEqualsJsonFile($file, $this->actual, $this->description);
    }

    /**
     * Assert SUT's contents as XML are not the same as the XML in a given file.
     *
     * @param string $file XML file SUT is expected to differ from
     */
    public function doesNotEqualXmlFile($file)
    {
        a::assertXmlFileNotEqualsXmlFile($file, $this->actual, $this->description);
    }

    /**
     * Assert SUT does not exist in the filesystem.
     */
    public function doesNotExist()
    {
        a::assertFileNotExists($this->actual, $this->description);
    }

    /**
     * Assert contents of SUT are equal to another given file's contents.
     *
     * @param string $expected Name of file SUT is expected to be equal to
     */
    public function equals($expected)
    {
        a::assertFileEquals($expected, $this->actual, $this->description, $this->ignoreOrder, $this->ignoreCase);
    }

    /**
     * Assert SUT's contents as JSON value are equal to the JSON contents of a given file.
     *
     * @param string $file JSON file SUT is expected to be the same as
     */
    public function equalsJsonFile($file)
    {
        a::assertJsonFileEqualsJsonFile($file, $this->actual, $this->description);
    }

    /**
     * Assert SUT's contents as XML are the same as the XML in a given file.
     *
     * @param string $file XML file SUT is expected to be the same as
     */
    public function equalsXmlFile($file)
    {
        a::assertXmlFileEqualsXmlFile($file, $this->actual, $this->description);
    }

    /**
     * Assert SUT exists in the filesystem.
     */
    public function exists()
    {
        a::assertFileExists($this->actual, $this->description);
    }
}
