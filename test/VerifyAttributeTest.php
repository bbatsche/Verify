<?php

declare(strict_types=1);

namespace BeBat\Verify\Test;

use Mockery;
use function BeBat\Verify\verify;

class VerifyAttributeTest extends UnitTestBase
{
    public function testAttributeFunctions()
    {
        $obj1 = verify('value');

        $this->assertAttributeEmpty('attributeName', $obj1);

        $obj2 = verify('value')->attrMagicMethod;

        $this->assertInstanceOf('BeBat\\Verify\\Verify', $obj2);
        $this->assertAttributeSame('attrMagicMethod', 'attributeName', $obj2);

        $obj3 = verify('value')->attribute('attributeCall');

        $this->assertInstanceOf('BeBat\\Verify\\Verify', $obj3);
        $this->assertAttributeSame('attributeCall', 'attributeName', $obj3);
    }

    public function testContains()
    {
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                Mockery::any(), // Object Identity
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->contains('test 1'));
        $this->assertNull(verify('message', 'subject 2')->attribute2->contains('test 2'));
    }

    public function testContainsOnly()
    {
        $obj = new \stdClass();

        $this->mockAssert->shouldReceive('assertAttributeContainsOnly')
            ->with('TypeA', 'attribute1', $obj, null, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertAttributeContainsOnly')
            ->with('TypeB', 'attribute2', $obj, null, 'message')->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContainsOnly')
            ->with('TypeC', 'attribute3', $obj, null, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContainsOnly')
            ->with('TypeD', 'attribute4', $obj, null, 'message')->once();

        $this->assertNull(verify($obj)->attribute1->containsOnly('TypeA'));
        $this->assertNull(verify('message', $obj)->attribute2->containsOnly('TypeB'));

        $this->assertNull(verify($obj)->attribute3->doesNotContainOnly('TypeC'));
        $this->assertNull(verify('message', $obj)->attribute4->doesNotContainOnly('TypeD'));
    }

    public function testCount()
    {
        $this->mockAssert->shouldReceive('assertAttributeCount')
            ->with(1, 'attribute1', 'subject 1', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertAttributeCount')
            ->with(2, 'attribute2', 'subject 2', 'message')->once();

        $this->assertNull(verify('subject 1')->attribute1->hasCount(1));
        $this->assertNull(verify('message', 'subject 2')->attribute2->hasCount(2));

        $this->mockAssert->shouldReceive('assertAttributeNotCount')
            ->with(3, 'attribute3', 'subject 3', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertAttributeNotCount')
            ->with(4, 'attribute4', 'subject 4', 'message')->once();

        $this->assertNull(verify('subject 3')->attribute3->doesNotHaveCount(3));
        $this->assertNull(verify('message', 'subject 4')->attribute4->doesNotHaveCount(4));
    }

    public function testDataTypeContains()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                Mockery::any(), // Object Identity
                false
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->contains('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->contains('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withoutType()->contains('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withoutType()->contains('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withType()->contains('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withType()->contains('test 6'));
    }

    public function testDataTypeNotContains()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                Mockery::any(), // Object Identity
                false
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->doesNotContain('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->doesNotContain('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withoutType()->doesNotContain('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withoutType()->doesNotContain('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withType()->doesNotContain('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withType()->doesNotContain('test 6'));
    }

    public function testEmpty()
    {
        $this->singleValueAttrTest('isEmpty', 'assertAttributeEmpty');
        $this->singleValueAttrTest('isNotEmpty', 'assertAttributeNotEmpty');
    }

    public function testEquals()
    {
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->equals('test 1'));
        $this->assertNull(verify('message', 'subject 2')->attribute2->equals('test 2'));
    }

    public function testFloatingPointEquals()
    {
        // Default: 0.0
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                0.0,
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                0.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->equals('test 2'));

        // Specified value: 1.0
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->within(1.0)->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->within(1.0)->equals('test 4'));
    }

    public function testFloatingPointNotEquals()
    {
        // Default: 0.0
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                0.0,
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                0.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->doesNotEqual('test 2'));

        // Specified value: 1.0
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->within(1.0)->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->within(1.0)->doesNotEqual('test 4'));
    }

    public function testIgnoreCaseContains()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                false,
                Mockery::any(), // Object Identity
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->contains('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->contains('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                false,
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withCase()->contains('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withCase()->contains('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                true,
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                true,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withoutCase()->contains('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withoutCase()->contains('test 6'));
    }

    public function testIgnoreCaseEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->equals('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withCase()->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withCase()->equals('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withoutCase()->equals('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withoutCase()->equals('test 6'));
    }

    public function testIgnoreCaseNotContain()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                false,
                Mockery::any(), // Object Identity
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->doesNotContain('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->doesNotContain('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                false,
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withCase()->doesNotContain('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withCase()->doesNotContain('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                true,
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                true,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withoutCase()->doesNotContain('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withoutCase()->doesNotContain('test 6'));
    }

    public function testIgnoreCaseNotEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->doesNotEqual('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withCase()->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withCase()->doesNotEqual('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withoutCase()->doesNotEqual('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withoutCase()->doesNotEqual('test 6'));
    }

    public function testIgnoreOrderEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                false,
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->equals('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withOrder()->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withOrder()->equals('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeEquals')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withoutOrder()->equals('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withoutOrder()->equals('test 6'));
    }

    public function testIgnoreOrderNotEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                false,
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->doesNotEqual('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withOrder()->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withOrder()->doesNotEqual('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withoutOrder()->doesNotEqual('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withoutOrder()->doesNotEqual('test 6'));
    }

    public function testInstanceOf()
    {
        $this->twoValueAttrTest('isInstanceOf', 'assertAttributeInstanceOf');
        $this->twoValueAttrTest('isNotInstanceOf', 'assertAttributeNotInstanceOf');
    }

    public function testInternalType()
    {
        $this->twoValueAttrTest('isInternalType', 'assertAttributeInternalType');
        $this->twoValueAttrTest('isNotInternalType', 'assertAttributeNotInternalType');
    }

    public function testNotContain()
    {
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                Mockery::any(), // Object Identity
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->doesNotContain('test 1'));
        $this->assertNull(verify('message', 'subject 2')->attribute2->doesNotContain('test 2'));
    }

    public function testNotEquals()
    {
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotEquals')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->doesNotEqual('test 1'));
        $this->assertNull(verify('message', 'subject 2')->attribute2->doesNotEqual('test 2'));
    }

    public function testObjectIdentityContains()
    {
        // Default: true
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                true,
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->contains('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->contains('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withoutIdentity()->contains('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withoutIdentity()->contains('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeContains')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withIdentity()->contains('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withIdentity()->contains('test 6'));
    }

    public function testObjectIdentityNotContains()
    {
        // Default: true
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 1',
                'attribute1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                true,
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 2',
                'attribute2',
                'subject 2',
                'message 2',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->attribute1->doesNotContain('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->attribute2->doesNotContain('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 3',
                'attribute3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 4',
                'attribute4',
                'subject 4',
                'message 4',
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->attribute3->withoutIdentity()->doesNotContain('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->attribute4->withoutIdentity()->doesNotContain('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 5',
                'attribute5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertAttributeNotContains')
            ->with(
                'test 6',
                'attribute6',
                'subject 6',
                'message 6',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->attribute5->withIdentity()->doesNotContain('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->attribute6->withIdentity()->doesNotContain('test 6'));
    }

    public function testRelativeInequality()
    {
        $this->twoValueAttrTest('isGreaterThan', 'assertAttributeGreaterThan');
        $this->twoValueAttrTest('isLessThan', 'assertAttributeLessThan');
        $this->twoValueAttrTest('isGreaterOrEqualTo', 'assertAttributeGreaterThanOrEqual');
        $this->twoValueAttrTest('isLessOrEqualTo', 'assertAttributeLessThanOrEqual');
    }

    public function testSame()
    {
        $this->twoValueAttrTest('sameAs', 'assertAttributeSame');
        $this->twoValueAttrTest('notSameAs', 'assertAttributeNotSame');
    }

    protected function singleValueAttrTest($verifyMethod, $assertMethod)
    {
        $this->mockAssert->shouldReceive($assertMethod)->with('attribute1', 'subject 1', Mockery::any())->once();
        $this->mockAssert->shouldReceive($assertMethod)->with('attribute2', 'subject 2', 'message')->once();

        $this->assertNull(verify('subject 1')->attribute1->{$verifyMethod}());
        $this->assertNull(verify('message', 'subject 2')->attribute2->{$verifyMethod}());
    }

    protected function twoValueAttrTest($verifyMethod, $assertMethod)
    {
        $this->mockAssert->shouldReceive($assertMethod)->with('test 1', 'attribute1', 'subject 1', Mockery::any())->once();
        $this->mockAssert->shouldReceive($assertMethod)->with('test 2', 'attribute2', 'subject 2', 'message')->once();

        $this->assertNull(verify('subject 1')->attribute1->{$verifyMethod}('test 1'));
        $this->assertNull(verify('message', 'subject 2')->attribute2->{$verifyMethod}('test 2'));
    }
}
