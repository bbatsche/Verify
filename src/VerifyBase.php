<?php namespace BBat\Verify;

abstract class VerifyBase
{
    protected $actual;
    protected $description;

    public function __construct()
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
}
