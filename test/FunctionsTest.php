<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BadFunctionCallException;
use BeBat\Verify\Verify;
use BeBat\Verify\VerifyDirectory;
use BeBat\Verify\VerifyFile;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

/**
 * @internal
 */
final class FunctionsTest extends TestCase
{
    /**
     * Test verify*() methods' default behavior.
     *
     * @param class-string $className
     *
     * @dataProvider verifyFunctions
     *
     * @return void
     */
    public function testFunction(string $functionName, string $className)
    {
        $object = $functionName('no message');

        $this->assertInstanceOf($className, $object);

        $reflection = new ReflectionObject($object);

        $actual = $reflection->getProperty('actual');
        $actual->setAccessible(true);

        $this->assertSame('no message', $actual->getValue($object));

        $actual->setAccessible(false);

        $object = $functionName('some message', 'message included');

        $this->assertInstanceOf($className, $object);

        $reflection = new ReflectionObject($object);

        $actual      = $reflection->getProperty('actual');
        $description = $reflection->getProperty('description');

        $actual->setAccessible(true);
        $description->setAccessible(true);

        $this->assertSame('message included', $actual->getValue($object));
        $this->assertSame('some message', $description->getValue($object));

        $actual->setAccessible(false);
        $description->setAccessible(false);
    }

    /**
     * Test exception thrown with zero arguments.
     *
     * @dataProvider verifyFunctions
     *
     * @return void
     */
    public function testFunctionNoArguments(string $functionName)
    {
        $this->expectException(BadFunctionCallException::class);
        $functionName();
    }

    /**
     * Test exception thrown with too many arguments.
     *
     * @dataProvider verifyFunctions
     *
     * @return void
     */
    public function testFunctionTooManyArguments(string $functionName)
    {
        $this->expectException(BadFunctionCallException::class);
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
