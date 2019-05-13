<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BeBat\Verify\VerifyFile;
use Mockery;

/**
 * @internal
 */
final class VerifyFileTest extends UnitTestBase
{
    protected $defaultActualValue = 'file under test';

    /**
     * VerifyFile class.
     *
     * @var \BeBat\Verify\VerifyFile
     */
    protected $subject;

    protected function setUp()
    {
        $this->subject = new VerifyFile($this->defaultActualValue, 'some message');

        parent::setUp();
    }

    /**
     * All VerifyFile methods.
     */
    public function allMethods(): array
    {
        return [
            ['equalTo'],
            ['equalToJsonFile'],
            ['equalToXmlFile'],
            ['exist'],
            ['readable'],
            ['writable'],
        ];
    }

    /**
     * PHPUnit assertions used by VerifyFile::equalTo().
     */
    public function equalToMethods(): array
    {
        return [
            [true,  'assertFileEquals'],
            [false, 'assertFileNotEquals'],
        ];
    }

    /**
     * All VerifyFile methods and their PHPUnit assertions that do not take a value for comparison.
     */
    public function noParamMethods(): array
    {
        return [
            [true,  'exist',    'assertFileExists'],
            [true,  'readable', 'assertFileIsReadable'],
            [true,  'writable', 'assertFileIsWritable'],
            [false, 'exist',    'assertFileNotExists'],
            [false, 'readable', 'assertFileNotIsReadable'],
            [false, 'writable', 'assertFileNotIsWritable'],
        ];
    }

    /**
     * All VerifyFile methods and their PHPUnit assertions that take in a single parameter.
     */
    public function singleParamMethods(): array
    {
        return [
            [true,  'equalToJsonFile', 'assertJsonFileEqualsJsonFile'],
            [true,  'equalToXmlFile',  'assertXmlFileEqualsXmlFile'],
            [false, 'equalToJsonFile', 'assertJsonFileNotEqualsJsonFile'],
            [false, 'equalToXmlFile',  'assertXmlFileNotEqualsXmlFile'],
        ];
    }

    /**
     * Test VerifyFile::equalTo().
     *
     * @dataProvider equalToMethods
     */
    public function testEqualTo(bool $modifierConition, string $assertMethod)
    {
        $this->setModifierCondition($modifierConition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('file name', $this->defaultActualValue, 'some message', false, Mockery::any())
            ->once();

        $this->assertSame($this->subject, $this->subject->equalTo('file name'));

        $this->subject = new VerifyFile('subject file with case', 'message with case');
        $this->setModifierCondition($modifierConition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('expected file with case', 'subject file with case', 'message with case', false, false)
            ->once();

        $this->assertSame($this->subject, $this->subject->withCase()->equalTo('expected file with case'));

        $this->subject = new VerifyFile('subject file w/o case', 'message w/o case');
        $this->setModifierCondition($modifierConition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('expected file w/o case', 'subject file w/o case', 'message w/o case', false, true)
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->equalTo('expected file w/o case'));
    }
}
