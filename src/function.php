<?php

declare(strict_types=1);

namespace BeBat\Verify;

/**
 * Interface into Verify library and main set of assertions.
 *
 * @param string|mixed $description When called with a single parameter, will be used as the
 *                                  Subject Under Test (SUT). When called with two parameters,
 *                                  will be used as a description to display if the assertion fails.
 * @param mixed        $actual      Optional value for SUT when called with two arguments
 *
 * @throws \BadMethodCallException When called with 0 arguments, or more than two arguments
 *
 * @return \BeBat\Verify\Verify
 */
function verify()
{
    switch (\func_num_args()) {
        case 1:
            return new Verify(\func_get_arg(0));
        case 2:
            return new Verify(\func_get_arg(1), \func_get_arg(0));
        default:
            throw new \BadMethodCallException('verify() must be called with exactly 1 or 2 arguments.');
    }
}

/**
 * Assert a value is not empty or "true".
 *
 * @param mixed $truth SUT expected to be not empty
 */
function verify_that($truth)
{
    verify($truth)->isNotEmpty();
}

/**
 * Assert a value is empty or "false".
 *
 * @param mixed $fallacy SUT expected to be empty
 */
function verify_not($fallacy)
{
    verify($fallacy)->isEmpty();
}

/**
 * Interface into Verify with assertions specific to file system objects.
 *
 * @param string $description When called with a single parameter, will be used as the Subject
 *                            Under Test (SUT) file name. When called with two parameters,
 *                            will be used as a description to display if the assertion fails.
 * @param string $actual      Optional file name for SUT when called with two arguments
 *
 * @throws \BadMethodCallException When called with 0 arguments, or more than two arguments
 *
 * @return \BeBat\Verify\VerifyFile
 */
function verify_file()
{
    switch (\func_num_args()) {
        case 1:
            return new VerifyFile(\func_get_arg(0));
        case 2:
            return new VerifyFile(\func_get_arg(1), \func_get_arg(0));
        default:
            throw new \BadMethodCallException('verify_file() must be called with exactly 1 or 2 arguments.');
    }
}

/**
 * Interface into Verify with assertions specific to file system directories.
 *
 * @param string $description When called with a single parameter, will be used as the Subject
 *                            Under Test (SUT) file name. When called with two parameters,
 *                            will be used as a description to display if the assertion fails.
 * @param string $actual      Optional file name for SUT when called with two arguments
 *
 * @throws \BadMethodCallException When called with 0 arguments, or more than two arguments
 *
 * @return \BeBat\Verify\VerifyDirectory
 */
function verify_directory()
{
    switch (\func_num_args()) {
        case 1:
            return new VerifyDirectory(\func_get_arg(0));
        case 2:
            return new VerifyDirectory(\func_get_arg(1), \func_get_arg(0));
        default:
            throw new \BadMethodCallException('verify_directory() must be called with exactly 1 or 2 arguments.');
    }
}
