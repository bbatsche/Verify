<?php

if (!function_exists('verify')) {

    /**
     * @param $description
     * @param null $actual
     * @return \BBat\Verify
     */
    function verify($description) {
        $reflect = new ReflectionClass('\BBat\Verify\Verify');
        return $reflect->newInstanceArgs(func_get_args());
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
        $reflect = new ReflectionClass('\BBat\Verify\VerifyFile');
        return $reflect->newInstanceArgs(func_get_args());
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
