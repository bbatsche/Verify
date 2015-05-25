<?php

use BBat\Verify\Verify;
use BBat\Verify\VerifyFile;

if (!function_exists('verify')) {

    /**
     * @param $description
     * @param null $actual
     * @return \BBat\Verify
     */
    function verify() {
        switch(func_num_args()) {
            case 1:
                return new Verify(func_get_arg(0));
            case 2:
                return new Verify(func_get_arg(1), func_get_arg(0));
            default:
                throw new \BadMethodCallException('VerifyFile must take 1 or 2 arguments.');
        }
    }

    function verify_that($truth) {
        verify($truth)->isNotEmpty();
    }

    function verify_not($fallacy) {
        verify($fallacy)->isEmpty();
    }
}

if (!function_exists('expect')) {

    /**
     * @param $description
     * @param null $actual
     * @return \BBat\Verify
     */
    function expect() {
        return call_user_func_array('verify', func_get_args());
     }

    function expect_that($truth) {
        expect($truth)->isNotEmpty();
    }

    function expect_not($fallacy) {
        expect($fallacy)->isEmpty();
    }

}

if (!function_exists('verify_file')) {

    /**
     * @param $description
     * @param null $actual
     * @return \BBat\Verify
     */
    function verify_file() {
        switch(func_num_args()) {
            case 1:
                return new VerifyFile(func_get_arg(0));
            case 2:
                return new VerifyFile(func_get_arg(1), func_get_arg(0));
            default:
                throw new \BadMethodCallException('VerifyFile must take 1 or 2 arguments.');
        }
    }
}

if (!function_exists('expect_file')) {
    /**
     * @param $description
     * @param null $actual
     * @return \BBat\Verify
     */
    function expect_file() {
        return call_user_func_array('verify_file', func_get_args());
    }
}
