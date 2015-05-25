<?php namespace BBat\Verify;

abstract class VerifyBase
{
    protected $actual;

    protected $description = '';

    public function __construct($actual, $description = '')
    {
        $this->actual      = $actual;
        $this->description = $description;
    }
}
