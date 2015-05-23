<?php namespace BBat\Verify;

use BBat\Verify\Asserts as a;

class VerifyFile
{
    protected $actual;
    protected $description;

    public function __constrcut()
    {
        switch(func_num_args()) {
            case 1:
                $this->actual = func_get_arg(0);
                break;
            case 2:
                $this->description = func_get_arg(0);
                $this->actual      = func_get_arg(1);
                break;
            default:
                throw new \BadMethodCallException('VerifyFile must take 1 or 2 arguments.');
        }
    }

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

    public function equalsXmlFile($file)
    {
        a::assertXmlFileEqualsXmlFile($file, $this->actual, $this->description);
    }
}
