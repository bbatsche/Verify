<?php

require_once 'UnitTestBase.php';

class VerifyAttributeTest extends UnitTestBase
{
    public static function setUpBeforeClass()
    {
        static::$verifyMethod = 'verify';
    }

    public function testAttributeFunctions()
    {
        $obj1 = verify('value');

        $this->assertAttributeEmpty('attributeName', $obj1);

        $obj2 = verify('value')->attrMagicMethod;

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj2);
        $this->assertAttributeEquals('attrMagicMethod', 'attributeName', $obj2);

        $obj3 = verify('value')->attribute('attributeCall');

        $this->assertInstanceOf('BeBat\Verify\Verify', $obj3);
        $this->assertAttributeEquals('attributeCall', 'attributeName', $obj3);
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
}
