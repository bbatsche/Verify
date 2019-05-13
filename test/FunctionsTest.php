<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BeBat\Verify\Verify;
use BeBat\Verify\VerifyDirectory;
use BeBat\Verify\VerifyFile;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FunctionsTest extends TestCase
{
    /**
     * Test verify*() methods' default behavior.
     *
     * @dataProvider verifyFunctions
     */
    public function testFunction(string $functionName, string $className)
    {
        $object = $functionName('no message');

        $this->assertInstanceOf($className, $object);
        $this->assertAttributeSame('no message', 'actual', $object);

        $object = $functionName('some message', 'message included');

        $this->assertInstanceOf($className, $object);
        $this->assertAttributeSame('message included', 'actual', $object);
        $this->assertAttributeSame('some message', 'description', $object);
    }

    /**
     * Test exception thrown with zero arguments.
     *
     * @dataProvider verifyFunctions
     */
    public function testFunctionNoArguments(string $functionName)
    {
        $this->expectException(\BadFunctionCallException::class);
        $functionName();
    }

    /**
     * Test exception thrown with too many arguments.
     *
     * @dataProvider verifyFunctions
     */
    public function testFunctionTooManyArguments(string $functionName)
    {
        $this->expectException(\BadFunctionCallException::class);
        $functionName('param 1', 'param 2', 'param 3');
    }

    /**
     * All verify functions and their corresponding classes.
     */
    public function verifyFunctions(): array
    {
        return [
            ['BeBat\\Verify\\verify',           Verify::class],
            ['BeBat\\Verify\\verify_file',      VerifyFile::class],
            ['BeBat\\Verify\\verify_directory', VerifyDirectory::class],
        ];
    }
}
