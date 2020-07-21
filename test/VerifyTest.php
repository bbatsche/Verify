<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use BadMethodCallException;
use BeBat\Verify\Verify;
use DOMElement;
use Mockery;
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
            ['true'],
            ['false'],
            ['null'],
            ['empty'],
            ['json'],
            ['count', 30],
            ['key'],
            ['startWith'],
            ['endWith'],
            ['contain'],
            ['containOnly'],
            ['matchRegExp'],
            ['matchFormat'],
            ['matchFormatFile'],
            ['equalToJsonString'],
            ['equalToJsonFile'],
            ['equalToXmlString'],
            ['equalToXmlFile'],
            ['equalToXmlStructure', new DOMElement('foo')],
            ['greaterThan'],
            ['greaterOrEqualTo'],
            ['lessThan'],
            ['lessOrEqualTo'],
            ['finite'],
            ['infinite'],
            ['nan'],
            ['equalTo'],
            ['equalToFile'],
            ['sameAs'],
            ['sameSizeAs'],
            ['subset'],
            ['instanceOf'],
            ['internalType'],
            ['attribute'],
            ['staticAttribute'],
        ];
    }

    /**
     * Sample data for testing attribute() method.
     */
    public function attributeAssertMethods(): array
    {
        return [
            [true,  'SomeClass',     'assertClassHasAttribute'],
            [true,  new stdClass(), 'assertObjectHasAttribute'],
            [false, 'SomeClass',     'assertClassNotHasAttribute'],
            [false, new stdClass(), 'assertObjectNotHasAttribute'],
        ];
    }

    /**
     * Assert methods used by contain() for attributes.
     */
    public function attributeContainAssertMethods(): array
    {
        return [
            [true,  'assertAttributeContains'],
            [false, 'assertAttributeNotContains'],
        ];
    }

    /**
     * Assert methods used by containOnly() for attributes.
     */
    public function attributeContainOnlyAssertMethods(): array
    {
        return [
            [true,  'assertAttributeContainsOnly'],
            [false, 'assertAttributeNotContainsOnly'],
        ];
    }

    /**
     * Assert methods used by equalTo() for attributes.
     */
    public function attributeEqualToAssertMethods(): array
    {
        return [
            [true,  'assertAttributeEquals'],
            [false, 'assertAttributeNotEquals'],
        ];
    }

    /**
     * Verify methods and their PHPUnit assertions for object attributes.
     */
    public function attributeMethods(): array
    {
        return [
            [true,  'count',            'assertAttributeCount', 40],
            [true,  'greaterThan',      'assertAttributeGreaterThan'],
            [true,  'greaterOrEqualto', 'assertAttributeGreaterThanOrEqual'],
            [true,  'lessThan',         'assertAttributeLessThan'],
            [true,  'lessOrEqualto',    'assertAttributeLessThanOrEqual'],
            [true,  'instanceOf',       'assertAttributeInstanceOf'],
            [true,  'internalType',     'assertAttributeInternalType'],
            [true,  'sameAs',           'assertAttributeSame'],
            [false, 'count',            'assertAttributeNotCount', 50],
            [false, 'greaterThan',      'assertAttributeLessThanOrEqual'],
            [false, 'greaterOrEqualto', 'assertAttributeLessThan'],
            [false, 'lessThan',         'assertAttributeGreaterThanOrEqual'],
            [false, 'lessOrEqualto',    'assertAttributeGreaterThan'],
            [false, 'instanceOf',       'assertAttributeNotInstanceOf'],
            [false, 'internalType',     'assertAttributeNotInternalType'],
            [false, 'sameAs',           'assertAttributeNotSame'],
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
            [true,  'true',     'assertTrue'],
            [true,  'false',    'assertFalse'],
            [true,  'null',     'assertNull'],
            [true,  'empty',    'assertEmpty'],
            [true,  'finite',   'assertFinite'],
            [true,  'infinite', 'assertInfinite'],
            [true,  'nan',      'assertNan'],
            [true,  'json',     'assertJson'],
            [false, 'true',     'assertNotTrue'],
            [false, 'false',    'assertNotFalse'],
            [false, 'null',     'assertNotNull'],
            [false, 'empty',    'assertNotEmpty'],
            [false, 'finite',   'assertInfinite'],
            [false, 'infinite', 'assertFinite'],
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
     * Test Verify::contain() with & without case sensitivity for attributes.
     *
     * @dataProvider attributeContainAssertMethods
     *
     * @return void
     */
    public function testAttribueContainCaseSensitive(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('value with case', 'message with case');
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('attribute_with_case');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'needle with case',
                'attribute_with_case',
                'value with case',
                'message with case',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->withCase()->contain('needle with case'));

        $this->subject = new Verify('value w/o case', 'message w/o case');
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('attribute_without_case');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'needle w/o case',
                'attribute_without_case',
                'value w/o case',
                'message w/o case',
                true,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->withoutCase()->contain('needle w/o case'));
    }

    /**
     * Test Verify::contain() with & without data type for attributes.
     *
     * @dataProvider attributeContainAssertMethods
     *
     * @return void
     */
    public function testAttribueContainDataType(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('value with type', 'message with type');
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('attribute_with_type');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'needle with type',
                'attribute_with_type',
                'value with type',
                'message with type',
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertSame($this->subject, $this->subject->withType()->contain('needle with type'));

        $this->subject = new Verify('value w/o type', 'message w/o type');
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('attribute_without_type');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'needle w/o type',
                'attribute_without_type',
                'value w/o type',
                'message w/o type',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertSame($this->subject, $this->subject->withoutType()->contain('needle w/o type'));
    }

    /**
     * Test Verify::contain() with & without object identity for attributes.
     *
     * @dataProvider attributeContainAssertMethods
     *
     * @return void
     */
    public function testAttribueContainObjectIdentity(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('value with identity', 'message with identity');
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('attribute_with_identity');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'needle with identity',
                'attribute_with_identity',
                'value with identity',
                'message with identity',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->withIdentity()->contain('needle with identity'));

        $this->subject = new Verify('value w/o identity', 'message w/o identity');
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('attribute_without_identity');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'needle w/o identity',
                'attribute_without_identity',
                'value w/o identity',
                'message w/o identity',
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->withoutIdentity()->contain('needle w/o identity'));
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
     * Test negative assertions for object attributes.
     *
     * @param mixed $expectedValue
     *
     * @dataProvider attributeMethods
     *
     * @return void
     */
    public function testAttributeAssertions(
        bool $modifierCondition,
        string $verifyMethod,
        string $assertMethod,
        $expectedValue = 'some value'
    ) {
        $this->setModifierCondition($modifierCondition);

        $this->subject->attributeNamed('my_attribute');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with($expectedValue, 'my_attribute', 'actual value', 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->{$verifyMethod}($expectedValue));
    }

    /**
     * Test Verify::contain() basic case for attributes.
     *
     * @dataProvider attributeContainAssertMethods
     *
     * @return void
     */
    public function testAttributeContain(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('attribute_name');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('needle', 'attribute_name', 'actual value', 'some message', Mockery::any(), Mockery::any(), Mockery::any())
            ->once();

        $this->assertSame($this->subject, $this->subject->contain('needle'));
    }

    /**
     * Test Verify::containOnly() for object attributes.
     *
     * @dataProvider attributeContainOnlyAssertMethods
     *
     * @return void
     */
    public function testAttributeContainOnly(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('attribute_name');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with('data type', 'attribute_name', 'actual value', null, 'some message')
            ->once();

        $this->assertSame($this->subject, $this->subject->containOnly('data type'));
    }

    /**
     * Test Verify::equalTo() for attributes.
     *
     * @dataProvider attributeEqualToAssertMethods
     *
     * @return void
     */
    public function testAttributeEqualTo(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('my_attribute');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected value',
                'my_attribute',
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
     * Test Verify::equalTo() for attributes with or without case sensitivity.
     *
     * @dataProvider attributeEqualToAssertMethods
     *
     * @return void
     */
    public function testAttributeEqualToCaseSensitive(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('actual with case', 'message with case');
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('case_sensitive_attribute');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected with case',
                'case_sensitive_attribute',
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
        $this->subject->attributeNamed('uncase_sensitive_attribute');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected w/o case',
                'uncase_sensitive_attribute',
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
     * Test Verify::equalTo() for attributes with some float delta.
     *
     * @dataProvider attributeEqualToAssertMethods
     *
     * @return void
     */
    public function testAttributeEqualToFloatDelta(bool $modifierCondition, string $assertMethod)
    {
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('my_attribute');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected value',
                'my_attribute',
                'actual value',
                'some message',
                1.62,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertSame($this->subject, $this->subject->within(1.62)->equalTo('expected value'));
    }

    /**
     * Test Verify::equalTo() for attributes with or without order.
     *
     * @dataProvider attributeEqualToAssertMethods
     *
     * @return void
     */
    public function testAttributeEqualToOrder(bool $modifierCondition, string $assertMethod)
    {
        $this->subject = new Verify('actual with order', 'message with order');
        $this->setModifierCondition($modifierCondition);
        $this->subject->attributeNamed('ordered_attribute');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected with order',
                'ordered_attribute',
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
        $this->subject->attributeNamed('unordered_attribute');

        $this->mockAssert->shouldReceive($assertMethod)
            ->with(
                'expected w/o order',
                'unordered_attribute',
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
     * Test exception for invalid conjunction.
     *
     * @return void
     */
    public function testConjunctionException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->subject->some_invalid_conjunction();
        $this->assertAttributeSame(null, 'modifierCondition', $this->subject);
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

        $this->assertSame($this->subject, $this->subject->neutral_conjunction());
        $this->assertAttributeSame(null, 'modifierCondition', $this->subject);

        $this->assertSame($this->subject, $this->subject->positive_conjunction());
        $this->assertAttributeSame(true, 'modifierCondition', $this->subject);

        $this->assertSame($this->subject, $this->subject->negative_conjunction());
        $this->assertAttributeSame(false, 'modifierCondition', $this->subject);
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
