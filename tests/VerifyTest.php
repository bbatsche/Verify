<?php

require_once 'UnitTestBase.php';

use function BeBat\Verify\verify;
use function BeBat\Verify\verify_that;
use function BeBat\Verify\verify_not;

class VerifyTest extends UnitTestBase
{
    public static function setUpBeforeClass()
    {
        static::$verifyMethod = 'verify';
    }

    public function testVerifyFunction()
    {
        $obj = verify('value');

        $this->assertAttributeEquals('value', 'actual', $obj);
        $this->assertAttributeEmpty('description', $obj);

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj);

        $obj = verify('message', 'value');

        $this->assertAttributeEquals('value', 'actual', $obj);
        $this->assertAttributeEquals('message', 'description', $obj);

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj);
    }

    public function testVerifyTooManyArgs()
    {
        $this->expectException('BadMethodCallException');
        verify('arg1', 'arg2', 'arg3');
    }

    public function testVerifyTooFewArgs()
    {
        $this->expectException('BadMethodCallException');
        verify();
    }

    public function testShortHandMethods()
    {
        $this->mockAssert->shouldReceive('assertNotEmpty')->with('subject', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertEmpty')->with('subject', Mockery::any())->once();

        $this->assertNull(verify_that('subject'));
        $this->assertNull(verify_not('subject'));
    }

    public function testEquals()
    {
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->equals('test 1'));
        $this->assertNull(verify('message', 'subject 2')->equals('test 2'));
    }

    public function testNotEquals()
    {
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify('message', 'subject 2')->doesNotEqual('test 2'));
    }

    public function testFloatingPointEquals()
    {
        // Default: 0.0
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                0.0,
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                0.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->equals('test 2'));

        // Specified value: 1.0
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->within(1.0)->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->within(1.0)->equals('test 4'));
    }

    public function testFloatingPointNotEquals()
    {
        // Default: 0.0
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                0.0,
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                0.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotEqual('test 2'));

        // Specified value: 1.0
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                1.0,
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->within(1.0)->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->within(1.0)->doesNotEqual('test 4'));
    }

    public function testIgnoreOrderEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                false,
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->equals('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->withOrder()->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withOrder()->equals('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->withoutOrder()->equals('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutOrder()->equals('test 6'));
    }

    public function testIgnoreOrderNotEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                false,
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotEqual('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->withOrder()->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withOrder()->doesNotEqual('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->withoutOrder()->doesNotEqual('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutOrder()->doesNotEqual('test 6'));
    }

    public function testIgnoreCaseEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->equals('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->equals('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->withCase()->equals('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withCase()->equals('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertEquals')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->withoutCase()->equals('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutCase()->equals('test 6'));
    }

    public function testIgnoreCaseNotEquals()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Delta
                Mockery::any(), // Max Depth
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqual('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotEqual('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->withCase()->doesNotEqual('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withCase()->doesNotEqual('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertNotEquals')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->withoutCase()->doesNotEqual('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutCase()->doesNotEqual('test 6'));
    }

    public function testContains()
    {
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                Mockery::any(), // Object Identity
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->contains('test 1'));
        $this->assertNull(verify('message', 'subject 2')->contains('test 2'));
    }

    public function testNotContain()
    {
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                Mockery::any(), // Object Identity
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotContain('test 1'));
        $this->assertNull(verify('message', 'subject 2')->doesNotContain('test 2'));
    }

    public function testIgnoreCaseContains()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                false,
                Mockery::any(), // Object Identity
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->contains('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->contains('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                false,
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->withCase()->contains('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withCase()->contains('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                true,
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                true,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->withoutCase()->contains('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutCase()->contains('test 6'));
    }

    public function testIgnoreCaseNotContain()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                false,
                Mockery::any(), // Object Identity
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotContain('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotContain('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                false,
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                false,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->withCase()->doesNotContain('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withCase()->doesNotContain('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                true,
                Mockery::any(),
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                true,
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->withoutCase()->doesNotContain('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutCase()->doesNotContain('test 6'));
    }

    public function testObjectIdentityContains()
    {
        // Default: true
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                true,
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->contains('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->contains('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->withoutIdentity()->contains('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withoutIdentity()->contains('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->withIdentity()->contains('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withIdentity()->contains('test 6'));
    }

    public function testObjectIdentityNotContains()
    {
        // Default: true
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                true,
                Mockery::any()  // Data Type
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotContain('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotContain('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                false,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                false,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 3')->withoutIdentity()->doesNotContain('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withoutIdentity()->doesNotContain('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                true,
                Mockery::any()
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                true,
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 5')->withIdentity()->doesNotContain('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withIdentity()->doesNotContain('test 6'));
    }

    public function testDataTypeContains()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                Mockery::any(), // Object Identity
                false
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->contains('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->contains('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->withoutType()->contains('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withoutType()->contains('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertContains')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->withType()->contains('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withType()->contains('test 6'));
    }

    public function testDataTypeNotContains()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Ignore Case
                Mockery::any(), // Object Identity
                false
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->doesNotContain('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotContain('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                false
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->withoutType()->doesNotContain('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withoutType()->doesNotContain('test 4'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(),
                Mockery::any(),
                Mockery::any(),
                true
            )->once();
        $this->mockAssert->shouldReceive('assertNotContains')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->withType()->doesNotContain('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withType()->doesNotContain('test 6'));
    }

    public function testArraySubset()
    {
        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with('test 1', 'subject 1', Mockery::any(), Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with('test 2', 'subject 2', Mockery::any(), 'message')->once();

        $this->assertNull(verify('subject 1')->hasSubset('test 1'));
        $this->assertNull(verify('message', 'subject 2')->hasSubset('test 2'));
    }

    public function testDataTypeArraySubset()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with('test 1', 'subject 1', false, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with('test 2', 'subject 2', false, 'message 2')->once();

        $this->assertNull(verify('subject 1')->hasSubset('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->hasSubset('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with('test 3', 'subject 3', false, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with('test 4', 'subject 4', false, 'message 4')->once();

        $this->assertNull(verify('subject 3')->withoutType()->hasSubset('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withoutType()->hasSubset('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with('test 5', 'subject 5', true, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertArraySubset')
            ->with('test 6', 'subject 6', true, 'message 6')->once();

        $this->assertNull(verify('subject 5')->withType()->hasSubset('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withType()->hasSubset('test 6'));
    }

    public function testRelativeInequality()
    {
        $this->fireTwoValueTest('isGreaterThan',      'assertGreaterThan');
        $this->fireTwoValueTest('isLessThan',         'assertLessThan');
        $this->fireTwoValueTest('isGreaterOrEqualTo', 'assertGreaterThanOrEqual');
        $this->fireTwoValueTest('isLessOrEqualTo',    'assertLessThanOrEqual');
    }

    public function testTrueFalseNullEmpty()
    {
        $this->fireSingleValueTest('isTrue',     'assertTrue');
        $this->fireSingleValueTest('isNotTrue',  'assertNotTrue');
        $this->fireSingleValueTest('isFalse',    'assertFalse');
        $this->fireSingleValueTest('isNotFalse', 'assertNotFalse');
        $this->fireSingleValueTest('isNull',     'assertNull');
        $this->fireSingleValueTest('isNotNull',  'assertNotNull');
        $this->fireSingleValueTest('isEmpty',    'assertEmpty');
        $this->fireSingleValueTest('isNotEmpty', 'assertNotEmpty');
    }

    public function testHasKey()
    {
        $this->fireTwoValueTest('hasKey',         'assertArrayHasKey');
        $this->fireTwoValueTest('doesNotHaveKey', 'assertArrayNotHasKey');
    }

    public function testInstanceOf()
    {
        $this->fireTwoValueTest('isInstanceOf',    'assertInstanceOf');
        $this->fireTwoValueTest('isNotInstanceOf', 'assertNotInstanceOf');
    }

    public function testInternalType()
    {
        $this->fireTwoValueTest('isInternalType',    'assertInternalType');
        $this->fireTwoValueTest('isNotInternalType', 'assertNotInternalType');
    }

    public function testHasAttribute()
    {
        $obj = new stdClass();

        $this->mockAssert->shouldReceive('assertClassHasAttribute')
            ->with('attribute1', 'ClassA', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertClassHasAttribute')
            ->with('attribute2', 'ClassB', 'message')->once();

        $this->mockAssert->shouldReceive('assertObjectHasAttribute')
            ->with('attribute3', $obj, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertObjectHasAttribute')
            ->with('attribute4', $obj, 'message')->once();

        $this->mockAssert->shouldReceive('assertClassNotHasAttribute')
            ->with('attribute5', 'ClassC', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertClassNotHasAttribute')
            ->with('attribute6', 'ClassD', 'message')->once();

        $this->mockAssert->shouldReceive('assertObjectNotHasAttribute')
            ->with('attribute7', $obj, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertObjectNotHasAttribute')
            ->with('attribute8', $obj, 'message')->once();

        $this->mockAssert->shouldReceive('assertClassHasStaticAttribute')
            ->with('attribute9', 'ClassE', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertClassHasStaticAttribute')
            ->with('attributeA', 'ClassF', 'message')->once();

        $this->mockAssert->shouldReceive('assertClassNotHasStaticAttribute')
            ->with('attributeB', 'ClassG', Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertClassNotHasStaticAttribute')
            ->with('attributeC', 'ClassH', 'message')->once();

        $this->assertNull(verify('ClassA')->hasAttribute('attribute1'));
        $this->assertNull(verify('message', 'ClassB')->hasAttribute('attribute2'));

        $this->assertNull(verify($obj)->hasAttribute('attribute3'));
        $this->assertNull(verify('message', $obj)->hasAttribute('attribute4'));

        $this->assertNull(verify('ClassC')->doesNotHaveAttribute('attribute5'));
        $this->assertNull(verify('message', 'ClassD')->doesNotHaveAttribute('attribute6'));

        $this->assertNull(verify($obj)->doesNotHaveAttribute('attribute7'));
        $this->assertNull(verify('message', $obj)->doesNotHaveAttribute('attribute8'));

        $this->assertNull(verify('ClassE')->hasStaticAttribute('attribute9'));
        $this->assertNull(verify('message', 'ClassF')->hasStaticAttribute('attributeA'));

        $this->assertNull(verify('ClassG')->doesNotHaveStaticAttribute('attributeB'));
        $this->assertNull(verify('message', 'ClassH')->doesNotHaveStaticAttribute('attributeC'));
    }

    public function testContainsOnly()
    {
        $obj = new stdClass();

        $this->mockAssert->shouldReceive('assertContainsOnly')
            ->with('TypeA', $obj, null, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertContainsOnly')
            ->with('TypeB', $obj, null, 'message')->once();
        $this->mockAssert->shouldReceive('assertNotContainsOnly')
            ->with('TypeC', $obj, null, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertNotContainsOnly')
            ->with('TypeD', $obj, null, 'message')->once();

        $this->assertNull(verify($obj)->containsOnly('TypeA'));
        $this->assertNull(verify('message', $obj)->containsOnly('TypeB'));

        $this->assertNull(verify($obj)->doesNotContainOnly('TypeC'));
        $this->assertNull(verify('message', $obj)->doesNotContainOnly('TypeD'));
    }

    public function testCountAndSize()
    {
        $this->fireTwoValueTest('hasCount',         'assertCount');
        $this->fireTwoValueTest('doesNotHaveCount', 'assertNotCount');

        $this->fireTwoValueTest('sameSizeAs',    'assertSameSize');
        $this->fireTwoValueTest('notSameSizeAs', 'assertNotSameSize');
    }

    public function testJsonMethods()
    {
        $this->fireSingleValueTest('isJson', 'assertJson');

        $this->fireTwoValueTest('equalsJsonString',       'assertJsonStringEqualsJsonString');
        $this->fireTwoValueTest('doesNotEqualJsonString', 'assertJsonStringNotEqualsJsonString');

        $this->fireTwoValueTest('equalsJsonFile',       'assertJsonStringEqualsJsonFile');
        $this->fireTwoValueTest('doesNotEqualJsonFile', 'assertJsonStringNotEqualsJsonFile');
    }

    public function testRegExpFormats()
    {
        $this->fireTwoValueTest('matchesRegExp',      'assertRegExp');
        $this->fireTwoValueTest('doesNotMatchRegExp', 'assertNotRegExp');

        $this->fireTwoValueTest('matchesFormat',      'assertStringMatchesFormat');
        $this->fireTwoValueTest('doesNotMatchFormat', 'assertStringNotMatchesFormat');

        $this->fireTwoValueTest('matchesFormatFile',      'assertStringMatchesFormatFile');
        $this->fireTwoValueTest('doesNotMatchFormatFile', 'assertStringNotMatchesFormatFile');
    }

    public function testSame()
    {
        $this->fireTwoValueTest('sameAs',    'assertSame');
        $this->fireTwoValueTest('notSameAs', 'assertNotSame');
    }

    public function testStartsEndsWith()
    {
        $this->fireTwoValueTest('startsWith',       'assertStringStartsWith');
        $this->fireTwoValueTest('doesNotStartWith', 'assertStringStartsNotWith');

        $this->fireTwoValueTest('endsWith',       'assertStringEndsWith');
        $this->fireTwoValueTest('doesNotEndWith', 'assertStringEndsNotWith');
    }

    public function testEqualsFile()
    {
        $this->mockAssert->shouldReceive('assertStringEqualsFile')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertStringEqualsFile')
            ->with(
                'test 2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->equalsFile('test 1'));
        $this->assertNull(verify('message', 'subject 2')->equalsFile('test 2'));
    }

    public function testNotEqualsFile()
    {
        $this->mockAssert->shouldReceive('assertStringNotEqualsFile')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Canonicalize
                Mockery::any()  // Ignore Case
            )->once();
        $this->mockAssert->shouldReceive('assertStringNotEqualsFile')
            ->with(
                'test 2',
                'subject 2',
                'message',
                Mockery::any(),
                Mockery::any()
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqualFile('test 1'));
        $this->assertNull(verify('message', 'subject 2')->doesNotEqualFile('test 2'));
    }

    public function testIgnoreCaseEqualsFile()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertStringEqualsFile')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertStringEqualsFile')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->equalsFile('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->equalsFile('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertStringEqualsFile')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(), // Message
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertStringEqualsFile')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->withCase()->equalsFile('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withCase()->equalsFile('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertStringEqualsFile')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(), // Message
                Mockery::any(), // Canonicalize
                true
            )->once();
        $this->mockAssert->shouldReceive('assertStringEqualsFile')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->withoutCase()->equalsFile('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutCase()->equalsFile('test 6'));
    }

    public function testIgnoreCaseNotEqualsFile()
    {
        // Default: false
        $this->mockAssert->shouldReceive('assertStringNotEqualsFile')
            ->with(
                'test 1',
                'subject 1',
                Mockery::any(), // Message
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertStringNotEqualsFile')
            ->with(
                'test 2',
                'subject 2',
                'message 2',
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 1')->doesNotEqualFile('test 1'));
        $this->assertNull(verify('message 2', 'subject 2')->doesNotEqualFile('test 2'));

        // Explicitly false
        $this->mockAssert->shouldReceive('assertStringNotEqualsFile')
            ->with(
                'test 3',
                'subject 3',
                Mockery::any(), // Message
                Mockery::any(), // Canonicalize
                false
            )->once();
        $this->mockAssert->shouldReceive('assertStringNotEqualsFile')
            ->with(
                'test 4',
                'subject 4',
                'message 4',
                Mockery::any(),
                false
            )->once();

        $this->assertNull(verify('subject 3')->withCase()->doesNotEqualFile('test 3'));
        $this->assertNull(verify('message 4', 'subject 4')->withCase()->doesNotEqualFile('test 4'));

        // Explicitly true
        $this->mockAssert->shouldReceive('assertStringNotEqualsFile')
            ->with(
                'test 5',
                'subject 5',
                Mockery::any(), // Message
                Mockery::any(), // Canonicalize
                true
            )->once();
        $this->mockAssert->shouldReceive('assertStringNotEqualsFile')
            ->with(
                'test 6',
                'subject 6',
                'message 6',
                Mockery::any(),
                true
            )->once();

        $this->assertNull(verify('subject 5')->withoutCase()->doesNotEqualFile('test 5'));
        $this->assertNull(verify('message 6', 'subject 6')->withoutCase()->doesNotEqualFile('test 6'));
    }

    public function testXmlStructure()
    {
        $subject1 = new DOMDocument();
        $target1  = new DOMDocument();

        // Default: false
        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($target1, $subject1, false, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($target1, $subject1, false, 'message')->once();

        $this->assertNull(verify($subject1)->equalsXmlStructure($target1));
        $this->assertNull(verify('message', $subject1)->equalsXmlStructure($target1));

        // Explicitly false
        $subject2 = new DOMDocument();
        $target2  = new DOMDocument();

        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($target2, $subject2, false, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($target2, $subject2, false, 'message')->once();

        $this->assertNull(verify($subject2)->withoutAttributes()->equalsXmlStructure($target2));
        $this->assertNull(verify('message', $subject2)->withoutAttributes()->equalsXmlStructure($target2));

        // Explicitly false
        $subject3 = new DOMDocument();
        $target3  = new DOMDocument();

        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($target3, $subject3, true, Mockery::any())->once();
        $this->mockAssert->shouldReceive('assertEqualXMLStructure')
            ->with($target3, $subject3, true, 'message')->once();

        $this->assertNull(verify($subject3)->withAttributes()->equalsXmlStructure($target3));
        $this->assertNull(verify('message', $subject3)->withAttributes()->equalsXmlStructure($target3));
    }

    public function testXmlFilesString()
    {
        $this->fireTwoValueTest('equalsXmlFile',       'assertXmlStringEqualsXmlFile');
        $this->fireTwoValueTest('doesNotEqualXmlFile', 'assertXmlStringNotEqualsXmlFile');

        $this->fireTwoValueTest('equalsXmlString',       'assertXmlStringEqualsXmlString');
        $this->fireTwoValueTest('doesNotEqualXmlString', 'assertXmlStringNotEqualsXmlString');
    }
}
