<?php namespace BBat\Verify;

use BBat\Verify\Asserts as a;

class VerifyFile extends VerifyBase
{
    public function equals($expected)
    {
        a::assertFileEquals($expected, $this->actual, $this->description);
    }

    public function doesNotEqual($expected)
    {
        a::assertFileNotEquals($expected, $this->actual, $this->description);
    }

    public function exists()
    {
        a::assertFileExists($this->actual, $this->description);
    }

    public function doesNotExist()
    {
        a::assertFileNotExists($this->actual, $this->description);
    }

    public function equalsJsonFile($file)
    {
        a::assertJsonFileEqualsJsonFile($file, $this->actual, $this->description);
    }

    public function doesNotEqualJsonFile($file)
    {
        a::assertJsonFileNotEqualsJsonFile($file, $this->actual, $this->description);
    }

    public function equalsXmlFile($file)
    {
        a::assertXmlFileEqualsXmlFile($file, $this->actual, $this->description);
    }

    public function doesNotEqualXmlFile($file)
    {
        a::assertXmlFileNotEqualsXmlFile($file, $this->actual, $this->description);
    }
}
