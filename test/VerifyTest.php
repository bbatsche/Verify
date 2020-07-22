<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BadMethodCallException;
use BeBat\Verify\InvalidAttributeException;
use BeBat\Verify\InvalidSubjectException;
use BeBat\Verify\Verify;
use DOMElement;
use Mockery;
use phpmock\mockery\PHPMockery;
use ReflectionObject;
use stdClass;

/**
 * @internal
 */
final class VerifyTest extends UnitTestBase
{
    protected $defaultActualValue = 'actual value';

    /**
     * Verify class.
     *
     * @var \BeBat\Verify\Verify
     */
    protected $subject;

    /**
     * All possible verify methods.
     */
    public function allMethods(): array
    {
        return [
            ['array'],
            ['attribute'],
            ['bool'],
            ['callable'],
            ['contain'],
            ['containOnly'],
            ['count', 30],
            ['empty'],
            ['endWith'],
            ['equalTo'],
            ['equalToFile'],
            ['equalToJsonFile'],
            ['equalToJsonString'],
            ['equalToXmlFile'],
            ['equalToXmlString'],
            ['equalToXmlStructure', new DOMElement('foo')],
            ['false'],
            ['finite'],
            ['float'],
            ['greaterOrEqualTo'],
            ['greaterThan'],
            ['infinite'],
            ['instanceOf'],
            ['int'],
            ['internalType'],
            ['iterable'],
            ['json'],
            ['key'],
            ['lessOrEqualTo'],
            ['lessThan'],
            ['matchFormat'],
            ['matchFormatFile'],
            ['matchRegExp'],
            ['nan'],
            ['null'],
            ['numeric'],
            ['object'],
            ['resource'],
            ['sameAs'],
            ['sameSizeAs'],
            ['scalar'],
            ['startWith'],
            ['staticAttribute'],
            ['string'],
            ['subset'],
            ['true'],
        ];
    }

    /**
     * Sample data for testing attribute() method.
     */
    public function attributeAssertMethods(): array
    {
        return [
            [true,  'SomeClass',    'assertClassHasAttribute'],
            [true,  new stdClass(), 'assertObjectHasAttribute'],
            [false, 'SomeClass',    'assertClassNotHasAttribute'],
            [false, new stdClass(), 'assertObjectNotHasAttribute'],
        ];
    }

    /**
     * Stub objects and their attribute names & values.
     */
    public function attributeValues(): array
    {
        return [
            [Stub\ExampleChild::class, 'childStaticPrivate',    'child static private property'],
            [Stub\ExampleChild::class, 'childStaticProtected',  'child static protected property'],
            [Stub\ExampleChild::class, 'childStaticPublic',     'child static public property'],
            [Stub\ExampleChild::class, 'parentStaticPrivate',   'parent static private property'],
            [Stub\ExampleChild::class, 'parentStaticProtected', 'parent static protected property'],
            [Stub\ExampleChild::class, 'parentStaticPublic',    'parent static public property'],
            [new Stub\ExampleChild(),  'childPrivate',          'child private property'],
            [new Stub\ExampleChild(),  'childProtected',        'child protected property'],
            [new Stub\ExampleChild(),  'childPublic',           'child public property'],
            [new Stub\ExampleChild(),  'parentPrivate',         'parent private property'],
            [new Stub\ExampleChild(),  'parentProtected',       'parent protected property'],
            [new Stub\ExampleChild(),  'parentPublic',          'parent public property'],
        ];
    }

    /**
     * Assert methods used by contain().
     */
    public function containAssertMethods(): array
    {
        return [
            [true,  'assertContains'],
            [false, 'assertNotContains'],
        ];
    }

    /**
     * Assert methods used by containOnly().
     */
    public function containOnlyAssertMethods(): array
    {
        return [
            [true,  'assertContainsOnly'],
            [false, 'assertNotContainsOnly'],
        ];
    }

    /**
     * Assert methods used by equalTo().
     */
    public function equalToAssertMethods(): array
    {
        return [
            [true,  'assertEquals'],
            [false, 'assertNotEquals'],
        ];
    }

    /**
     * Assert methods used by equalToFile().
     */
    public function equalToFileAssertMethods(): array
    {
        return [
            [true,  'assertStringEqualsFile'],
            [false, 'assertStringNotEqualsFile'],
        ];
    }

    /**
     * Examples for invalid attribute exceptions.
     */
    public function invalidAttributes(): array
    {
        return [
            [Stub\ExampleChild::class, 'Could not find static property "some_attribute".'],
            [new Stub\ExampleChild(),  'Could not find object property "some_attribute".'],
        ];
    }

    /**
     * Subject values that should throw an exception when trying to access an attribute.
     */
    public function invalidSubjects(): array
    {
        return [
            ['Some\Missing\Class', 'Could not find class "Some\Missing\Class".'],
            [true,                 'Subject must be either an object or class name.'],
        ];
    }

    /**
     * Verify methods that cannot be used with a negative condition.
     */
    public function methodsWithoutNegativeCondition(): array
    {
        return [
            ['equalToXmlStructure', new DOMElement('foo')],
            ['json'],
            ['subset'],
            ['nan'],
        ];
    }

    /**
     * Verify methods and their PHPUnit assertions that don't take any comparison value.
     */
    public function noParamMethods(): array
    {
        return [
            [true,  'array',    'assertIsArray'],
            [true,  'bool',     'assertIsBool'],
            [true,  'callable', 'assertIsCallable'],
            [true,  'empty',    'assertEmpty'],
            [true,  'false',    'assertFalse'],
            [true,  'finite',   'assertFinite'],
            [true,  'float',    'assertIsFloat'],
            [true,  'infinite', 'assertInfinite'],
            [true,  'int',      'assertIsInt'],
            [true,  'iterable', 'assertIsIterable'],
            [true,  'json',     'assertJson'],
            [true,  'nan',      'assertNan'],
            [true,  'null',     'assertNull'],
            [true,  'numeric',  'assertIsNumeric'],
            [true,  'object',   'assertIsObject'],
            [true,  'resource', 'assertIsResource'],
            [true,  'scalar',   'assertIsScalar'],
            [true,  'string',   'assertIsString'],
            [true,  'true',     'assertTrue'],
            [false, 'array',    'assertIsNotArray'],
            [false, 'bool',     'assertIsNotBool'],
            [false, 'callable', 'assertIsNotCallable'],
            [false, 'empty',    'assertNotEmpty'],
            [false, 'false',    'assertNotFalse'],
            [false, 'finite',   'assertInfinite'],
            [false, 'float',    'assertIsNotFloat'],
            [false, 'infinite', 'assertFinite'],
            [false, 'int',      'assertIsNotInt'],
            [false, 'iterable', 'assertIsNotIterable'],
            [false, 'null',     'assertNotNull'],
            [false, 'numeric',  'assertIsNotNumeric'],
            [false, 'object',   'assertIsNotObject'],
            [false, 'resource', 'assertIsNotResource'],
            [false, 'scalar',   'assertIsNotScalar'],
            [false, 'string',   'assertIsNotString'],
            [false, 'true',     'assertNotTrue'],
        ];
    }

    /**
     * Verify methods and their PHPUNit assertions that take a comparison value.
     */
    public function singleParamMethods(): array
    {
        return [
            [true,  'count',             'assertCount', 10],
            [true,  'key',               'assertArrayHasKey'],
            [true,  'startWith',         'assertStringStartsWith'],
            [true,  'endWith',           'assertStringEndsWith'],
            [true,  'matchRegExp',       'assertRegExp'],
            [true,  'matchFormat',       'assertStringMatchesFormat'],
            [true,  'matchFormatFile',   'assertStringMatchesFormatFile'],
            [true,  'equalToJsonString', 'assertJsonStringEqualsJsonString'],
            [true,  'equalToJsonFile',   'assertJsonStringEqualsJsonFile'],
            [true,  'equalToXmlString',  'assertXmlStringEqualsXmlString'],
            [true,  'equalToXmlFile',    'assertXmlStringEqualsXmlFile'],
            [true,  'greaterThan',       'assertGreaterThan'],
            [true,  'greaterOrEqualTo',  'assertGreaterThanOrEqual'],
            [true,  'lessThan',          'assertLessThan'],
            [true,  'lessOrEqualTo',     'assertLessThanOrEqual'],
            [true,  'instanceOf',        'assertInstanceOf'],
            [true,  'internalType',      'assertInternalType'],
            [true,  'sameAs',            'assertSame'],
            [true,  'sameSizeAs',        'assertSameSize'],
            [true,  'staticAttribute',   'assertClassHasStaticAttribute'],
            [false, 'count',             'assertNotCount', 20],
            [false, 'key',               'assertArrayNotHasKey'],
            [false, 'startWith',         'assertStringStartsNotWith'],
            [false, 'endWith',           'assertStringEndsNotWith'],
            [false, 'matchRegExp',       'assertNotRegExp'],
            [false, 'matchFormat',       'assertStringNotMatchesFormat'],
            [false, 'matchFormatFile',   'assertStringNotMatchesFormatFile'],
            [false, 'equalToJsonString', 'assertJsonStringNotEqualsJsonString'],
            [false, 'equalToJsonFile',   'assertJsonStringNotEqualsJsonFile'],
            [false, 'equalToXmlString',  'assertXmlStringNotEqualsXmlString'],
            [false, 'equalToXmlFile',    'assertXmlStringNotEqualsXmlFile'],
            [false, 'greaterThan',       'assertLessThanOrEqual'],
            [false, 'greaterOrEqualTo',  'assertLessThan'],
            [false, 'lessThan',          'assertGreaterThanOrEqual'],
            [false, 'lessOrEqualTo',     'assertGreaterThan'],
            [false, 'instanceOf',        'assertNotInstanceOf'],
            [false, 'internalType',      'assertNotInternalType'],
            [false, 'sameAs',            'assertNotSame'],
            [false, 'sameSizeAs',        'assertNotSameSize'],
            [false, 'staticAttribute',   'assertClassNotHasStaticAttribute'],
        ];
    }

    /**
     * Test Verify::attribute().
     *
     * @param string|object $actualValue
     *
     * @dataProvider attributeAssertMethods
     *
     * @return void
     */
    public function testAttribute(bool $modifierCondition, $actualValue, string $assertMethod)
    {
        $this->subject = new Verify($actualValue, 'some message');

        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('attribute_name', $actualValue, 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->attribute('attribute_name'));
    }

    /**
     * Test exception for invalid conjunction.
     *
     * @return void
     */
    public function testConjunctionException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->subject->some_invalid_conjunction();
    }

    /**
     * Test conjunction magic method.
     *
     * @return void
     */
    public function testConjunctions()
    {
        Verify::$positiveConjunctions = ['positive_conjunction'];
        Verify::$negativeConjunctions = ['negative_conjunction'];
        Verify::$neutralConjunctions  = ['neutral_conjunction'];

        $reflection = new ReflectionObject($this->subject);

        $condition = $reflection->getProperty('modifierCondition');
        $condition->setAccessible(true);

        $this->assertSame($this->subject, $this->subject->neutral_conjunction());
        $this->assertNull($condition->getValue($this->subject));

        $this->assertSame($this->subject, $this->subject->positive_conjunction());
        $this->assertTrue($condition->getValue($this->subject));

        $this->assertSame($this->subject, $this->subject->negative_conjunction());
        $this->assertFalse($condition->getValue($this->subject));

        $condition->setAccessible(false);
    }

    /**
     * Test Verify::contain() basic case.
     *
     * @dataProvider containAssertMethods
     *
     * @return void
     */
    public function testContain(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('needle', 'actual value', 'some message', Mockery::any(), Mockery::any(), Mockery::any())
            ->once();

        $this->assertSame($this->subject, $this->subject->contain('needle'));
    }

    /**
     * Test Verify::contain() with & without case sensitivity.
     *
     * @dataProvider containAssertMethods
     *
     * @return void
     */
    public function testContainCaseSensitive(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('value with case', 'message with case');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('needle with case', 'value with case', 'message with case', false, Mockery::any(), Mockery::any())
            ->once();

        $this->assertSame($this->subject, $this->subject->withCase()->contain('needle with case'));

        $this->subject = new Verify('value w/o case', 'message w/o case');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('needle w/o case', 'value w/o case', 'message w/o case', true, Mockery::any(), Mockery::any())
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->contain('needle w/o case'));
    }

    /**
     * Test Verify::contain() with & without data type.
     *
     * @dataProvider containAssertMethods
     *
     * @return void
     */
    public function testContainDataType(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('value with type', 'message with type');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('needle with type', 'value with type', 'message with type', Mockery::any(), Mockery::any(), true)
            ->once();

        $this->assertSame($this->subject, $this->subject->withType()->contain('needle with type'));

        $this->subject = new Verify('value w/o type', 'message w/o type');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('needle w/o type', 'value w/o type', 'message w/o type', Mockery::any(), Mockery::any(), false)
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutType()->contain('needle w/o type'));
    }

    /**
     * Test Verify::contain() with & without object identity.
     *
     * @dataProvider containAssertMethods
     *
     * @return void
     */
    public function testContainObjectIdentity(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('value with identity', 'message with identity');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('needle with identity', 'value with identity', 'message with identity', Mockery::any(), true, Mockery::any())
            ->once();

        $this->assertSame($this->subject, $this->subject->withIdentity()->contain('needle with identity'));

        $this->subject = new Verify('value w/o identity', 'message w/o identity');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('needle w/o identity', 'value w/o identity', 'message w/o identity', Mockery::any(), false, Mockery::any())
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutIdentity()->contain('needle w/o identity'));
    }

    /**
     * Test Verify::containOnly().
     *
     * @dataProvider containOnlyAssertMethods
     *
     * @return void
     */
    public function testContainOnly(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('data type', 'actual value', null, 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->containOnly('data type'));
    }

    /**
     * Test Verify::equalTo().
     *
     * @dataProvider equalToAssertMethods
     *
     * @return void
     */
    public function testEqualTo(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected value',
                'actual value',
                'some message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->equalTo('expected value'));
    }

    /**
     * Test Verify::equalTo() with or without case sensitivity.
     *
     * @dataProvider equalToAssertMethods
     *
     * @return void
     */
    public function testEqualToCaseSensitive(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('actual with case', 'message with case');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected with case',
                'actual with case',
                'message with case',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertSame($this->subject, $this->subject->withCase()->equalTo('expected with case'));

        $this->subject = new Verify('actual w/o case', 'message w/o case');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected w/o case',
                'actual w/o case',
                'message w/o case',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->equalTo('expected w/o case'));
    }

    /**
     * Test Verify::equalToFile().
     *
     * @dataProvider equalToFileAssertMethods
     *
     * @return void
     */
    public function testEqualToFile(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'file name',
                'actual value',
                'some message',
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->equalToFile('file name'));
    }

    /**
     * Test Verify::equalToFile() with or without case sensitivity.
     *
     * @dataProvider equalToFileAssertMethods
     *
     * @return void
     */
    public function testEqualToFileCaseSensitive(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('actual with case', 'message with case');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'file with case',
                'actual with case',
                'message with case',
                Mockery::any(),
                false
            )->once();

        $this->assertSame($this->subject, $this->subject->withCase()->equalToFile('file with case'));

        $this->subject = new Verify('actual w/o case', 'message w/o case');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'file w/o case',
                'actual w/o case',
                'message w/o case',
                Mockery::any(),
                true
            )->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->equalToFile('file w/o case'));
    }

    /**
     * Test Verify::equalToFile() will call assertEqualToFileCaseSensitive() if available.
     *
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testEqualToFileSpecificMethods()
    {
        PHPMockery::mock('BeBat\\Verify', 'method_exists')->andReturn(true);

        $this->mockAssert->shouldNotReceive('assertStringEqualsFile');
        $this->mockAssert->shouldNotReceive('assertStringNotEqualsFile');

        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertStringEqualsFileIgnoringCase')
            ->with('case insensitive filename', 'actual value', 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->equalToFile('case insensitive filename'));

        $this->setModifierCondition(false);

        $this->mockAssert->shouldReceive('assertStringNotEqualsFileIgnoringCase')
            ->with('different case insensitive file', 'actual value', 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->equalToFile('different case insensitive file'));
    }

    /**
     * Test Verify::equalTo() with some float delta.
     *
     * @dataProvider equalToAssertMethods
     *
     * @return void
     */
    public function testEqualToFloatDelta(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected value',
                'actual value',
                'some message',
                6.28,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->within(6.28)->equalTo('expected value'));
    }

    /**
     * Test Verify::equalTo() with or without order.
     *
     * @dataProvider equalToAssertMethods
     *
     * @return void
     */
    public function testEqualToOrder(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('actual with order', 'message with order');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected with order',
                'actual with order',
                'message with order',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->withOrder()->equalTo('expected with order'));

        $this->subject = new Verify('actual w/o order', 'message w/o order');
        $this->setModifierCondition($modifierCondition);

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected w/o order',
                'actual w/o order',
                'message w/o order',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->withoutOrder()->equalTo('expected w/o order'));
    }

    /**
     * Test Verify::equalToXmlStructure().
     *
     * @return void
     */
    public function testEqualToXmlStructure()
    {
        $this->setModifierCondition(true);

        $expected = new DOMElement('expected');

        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($expected, 'actual value', Mockery::any(), 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->equalToXmlStructure($expected));

        $this->subject = new Verify('actual with attributes', 'message with attributes');
        $this->setModifierCondition(true);

        $expected = new DOMElement('with_attributes');

        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($expected, 'actual with attributes', true, 'message with attributes')
            ->once();

        $this->assertSame($this->subject, $this->subject->withAttributes()->equalToXmlStructure($expected));

        $this->subject = new Verify('actual w/o attributes', 'message w/o attributes');
        $this->setModifierCondition(true);

        $expected = new DOMElement('without_attributes');

        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($expected, 'actual w/o attributes', false, 'message w/o attributes')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutAttributes()->equalToXmlStructure($expected));
    }

    /**
     * Test reading attribute values.
     *
     * @param class-string|object $subject
     *
     * @dataProvider attributeValues
     *
     * @return void
     */
    public function testGetAttributeValue($subject, string $attributeName, string $attributeValue)
    {
        $this->subject = new Verify($subject);
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertTrue')
            ->with($attributeValue, Mockery::any())
            ->once();

        $this->assertSame($this->subject, $this->subject->attributeNamed($attributeName)->true());
    }

    /**
     * Test trying to read an invalid attribute will throw an exception.
     *
     * @param class-string|object $subject
     *
     * @dataProvider invalidAttributes
     *
     * @return void
     */
    public function testMissingAttributeThrowsException($subject, string $exceptionMessage)
    {
        $this->subject = new Verify($subject);
        $this->setModifierCondition(true);

        $this->expectException(InvalidAttributeException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $this->subject->attributeNamed('some_attribute')->true();
    }

    /**
     * Test validation of subject when trying to read an attribute.
     *
     * @param mixed $subject
     *
     * @dataProvider invalidSubjects
     *
     * @return void
     */
    public function testReadAttribueThrowsException($subject, string $exceptionMessage)
    {
        $this->subject = new Verify($subject);
        $this->setModifierCondition(true);

        $this->expectException(InvalidSubjectException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $this->subject->attributeNamed('some_attribute')->true();
    }

    /**
     * Test Verify::contains calls to specific assertContains*() methods.
     *
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testSpecificContainsMethods()
    {
        PHPMockery::mock('BeBat\\Verify', 'method_exists')->andReturn(true);

        $this->mockAssert->shouldNotReceive('assertContains');
        $this->mockAssert->shouldNotReceive('assertNotContains');

        $this->subject = new Verify('a string value', 'contains string in string');
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertStringContainsString')
            ->with('case sensitive string', 'a string value', 'contains string in string')
            ->once();
        $this->mockAssert->shouldReceive('assertStringContainsStringIgnoringCase')
            ->with('case insensitive string', 'a string value', 'contains string in string')
            ->once();

        $this->assertSame($this->subject, $this->subject->withCase()->contain('case sensitive string'));
        $this->assertSame($this->subject, $this->subject->withoutCase()->contain('case insensitive string'));

        $needle        = new stdClass();
        $this->subject = new Verify(['some', 'value'], 'loose compare objects in array');
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertContainsEquals')
            ->with($needle, ['some', 'value'], 'loose compare objects in array')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutIdentity()->contain($needle));

        $this->subject = new Verify(['different', 'values', '21'], 'loose compare scalar value');
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertContainsEquals')
            ->with(21, ['different', 'values', '21'], 'loose compare scalar value')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutType()->contain(21));

        $this->subject = new Verify('different string value', 'not contains string in string');
        $this->setModifierCondition(false);

        $this->mockAssert->shouldReceive('assertStringNotContainsString')
            ->with('case sensitive string', 'different string value', 'not contains string in string')
            ->once();
        $this->mockAssert->shouldReceive('assertStringNotContainsStringIgnoringCase')
            ->with('case insensitive string', 'different string value', 'not contains string in string')
            ->once();

        $this->assertSame($this->subject, $this->subject->withCase()->contain('case sensitive string'));
        $this->assertSame($this->subject, $this->subject->withoutCase()->contain('case insensitive string'));

        $needle        = new stdClass();
        $this->subject = new Verify(['negative', 'value'], 'loose compare objects in array');
        $this->setModifierCondition(false);

        $this->mockAssert->shouldReceive('assertNotContainsEquals')
            ->with($needle, ['negative', 'value'], 'loose compare objects in array')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutIdentity()->contain($needle));

        $this->subject = new Verify(['even', 'more', 'values'], 'loose compare scalar value');
        $this->setModifierCondition(false);

        $this->mockAssert->shouldReceive('assertNotContainsEquals')
            ->with('value', ['even', 'more', 'values'], 'loose compare scalar value')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutType()->contain('value'));
    }

    /**
     * Test Verify::equalTo() calls to specific assertEquals*() methods.
     *
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testSpecificEqualToMethods()
    {
        PHPMockery::mock('BeBat\\Verify', 'method_exists')->andReturn(true);

        $this->mockAssert->shouldNotReceive('assertEquals');
        $this->mockAssert->shouldNotReceive('assertNotEquals');

        $this->subject = new Verify(21, 'numeric value with delta');
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertEqualsWithDelta')
            ->with(2.72, 21, 12.12, 'numeric value with delta')
            ->once();

        $this->assertSame($this->subject, $this->subject->within(12.12)->equalTo(2.72));

        $this->subject = new Verify([3, 2, 1], 'array value without order');
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertEqualsCanonicalizing')
            ->with([1, 2, 3], [3, 2, 1], 'array value without order')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutOrder()->equalTo([1, 2, 3]));

        $this->subject = new Verify('a string value', 'string value without case');
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertEqualsIgnoringCase')
            ->with('A STRING VALUE', 'a string value', 'string value without case')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->equalTo('A STRING VALUE'));

        $this->subject = new Verify(5.2, 'numeric value with delta');
        $this->setModifierCondition(false);

        $this->mockAssert->shouldReceive('assertNotEqualsWithDelta')
            ->with(84, 5.2, 1.62, 'numeric value with delta')
            ->once();

        $this->assertSame($this->subject, $this->subject->within(1.62)->equalTo(84));

        $this->subject = new Verify([2, 4, 8], 'array value without order');
        $this->setModifierCondition(false);

        $this->mockAssert->shouldReceive('assertNotEqualsCanonicalizing')
            ->with([16, 32, 64], [2, 4, 8], 'array value without order')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutOrder()->equalTo([16, 32, 64]));

        $this->subject = new Verify('a different string', 'string value without case');
        $this->setModifierCondition(false);

        $this->mockAssert->shouldReceive('assertNotEqualsIgnoringCase')
            ->with('yet another string', 'a different string', 'string value without case')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->equalTo('yet another string'));
    }

    /**
     * Test Verify::subset().
     *
     * @return void
     */
    public function testSubset()
    {
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with(['subset'], 'actual value', Mockery::any(), 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->subset(['subset']));

        $this->subject = new Verify('actual with type', 'message with type');
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with(['subset with type'], 'actual with type', true, 'message with type')
            ->once();

        $this->assertSame($this->subject, $this->subject->withType()->subset(['subset with type']));

        $this->subject = new Verify('actual w/o type', 'message w/o type');
        $this->setModifierCondition(true);

        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with(['subset w/o type'], 'actual w/o type', false, 'message w/o type')
            ->once();

        $this->assertSame($this->subject, $this->subject->withoutType()->subset(['subset w/o type']));
    }

    /**
     * Test methods that do not support negative conditions throw an exception.
     *
     * @param mixed $value
     *
     * @dataProvider methodsWithoutNegativeCondition
     *
     * @return void
     */
    public function testUnsupportedNegativeCondition(string $methodName, $value = 'dummy value')
    {
        $this->setModifierCondition(false);

        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage($methodName . ' does not support negative condition.');

        $this->subject->{$methodName}($value);
    }

    protected function initSubject()
    {
        $this->subject = new Verify($this->defaultActualValue, 'some message');
    }
}
