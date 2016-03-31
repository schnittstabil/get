<?php

namespace Schnittstabil;

require 'Fixtures/ArrayAccessObject.php';

/**
 * Get tests.
 */
class GetTest extends \PHPUnit_Framework_TestCase
{
    use \VladaHejda\AssertException;

    public function testGetValueShouldReturnArrayValues()
    {
        $array = ['foo', 'bar'];
        $this->assertEquals(Get::value(1, $array), 'bar');
        $this->assertEquals(Get::value(2, $array), null);
        $this->assertEquals(Get::value(2, $array, 42), 42);
    }

    public function testGetValueShouldReturnNestedArrayValues()
    {
        $array = ['foo', ['bar', 'foobar']];
        $this->assertEquals(Get::value([1, 0], $array), 'bar');
        $this->assertEquals(Get::value([1, 2], $array), null);
        $this->assertEquals(Get::value([1, 2], $array, 42), 42);
    }

    public function testGetValueShouldReturnNamedArrayValues()
    {
        $array = ['foo' => 'bar'];
        $this->assertEquals(Get::value('foo', $array), 'bar');
        $this->assertEquals(Get::value('bar', $array), null);
        $this->assertEquals(Get::value('bar', $array, 42), 42);
    }

    public function testGetValueShouldReturnNestedNamedArrayValues()
    {
        $array = ['foo' => ['bar' => 'foobar']];
        $this->assertEquals(Get::value(['foo', 'bar'], $array), 'foobar');
        $this->assertEquals(Get::value(['foo', 'foobar'], $array), null);
        $this->assertEquals(Get::value(['foo', 'foobar'], $array, 42), 42);
    }

    public function testGetValueShouldReturnArrayAccessValues()
    {
        $arrayAccesss = new Fixtures\ArrayAccessObject(['foo', 'bar']);
        $this->assertEquals(Get::value(1, $arrayAccesss), 'bar');
        $this->assertEquals(Get::value(2, $arrayAccesss), null);
        $this->assertEquals(Get::value(2, $arrayAccesss, 42), 42);
    }

    public function testGetValueShouldReturnNestedArrayAccessValues()
    {
        $arrayAccesss = new Fixtures\ArrayAccessObject(['foo', ['bar', 'foobar']]);
        $this->assertEquals(Get::value([1, 0], $arrayAccesss), 'bar');
        $this->assertEquals(Get::value([1, 2], $arrayAccesss), null);
        $this->assertEquals(Get::value([1, 2], $arrayAccesss, 42), 42);
    }

    public function testGetValueShouldReturnNamedArrayAccessValues()
    {
        $arrayAccesss = new Fixtures\ArrayAccessObject(['foo' => 'bar']);
        $this->assertEquals(Get::value('foo', $arrayAccesss), 'bar');
        $this->assertEquals(Get::value('bar', $arrayAccesss), null);
        $this->assertEquals(Get::value('bar', $arrayAccesss, 42), 42);
    }

    public function testGetValueShouldReturnNestedNamedArrayAccessValues()
    {
        $arrayAccesss = new Fixtures\ArrayAccessObject(['foo' => ['bar' => 'foobar']]);
        $this->assertEquals(Get::value(['foo', 'bar'], $arrayAccesss), 'foobar');
        $this->assertEquals(Get::value(['foo', 'foobar'], $arrayAccesss), null);
        $this->assertEquals(Get::value(['foo', 'foobar'], $arrayAccesss, 42), 42);
    }

    public function testGetValueShouldReturnObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->assertEquals(Get::value('foo', $object), 'bar');
        $this->assertEquals(Get::value('bar', $object), null);
        $this->assertEquals(Get::value('bar', $object, 42), 42);
    }

    public function testGetValueShouldReturnNestedObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->assertEquals(Get::value(['foo', 'bar'], $object), 'foobar');
        $this->assertEquals(Get::value(['foo', 'foobar'], $object), null);
        $this->assertEquals(Get::value(['foo', 'foobar'], $object, 42), 42);
    }

    public function testGetValueShouldReturnMixedValues()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->assertEquals(Get::value(['foo', 'bar'], $object), 'foobar');
        $this->assertEquals(Get::value(['foo', 'foobar'], $object), null);
        $this->assertEquals(Get::value(['foo', 'foobar'], $object, 42), 42);

        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->assertEquals(Get::value(['foo', 'bar'], $array), 'foobar');
        $this->assertEquals(Get::value(['foo', 'foobar'], $array), null);
        $this->assertEquals(Get::value(['foo', 'foobar'], $array, 42), 42);
    }

    public function testGetValueShouldWorkWithNull()
    {
        $this->assertEquals(Get::value('foo', null), null);
        $this->assertEquals(Get::value('foo', null, 42), 42);
        $this->assertEquals(Get::value(['foo', 'bar'], null), null);
        $this->assertEquals(Get::value(['foo', 'bar'], null, 42), 42);
    }

    public function testGetValueOrFailShouldReturnArrayValues()
    {
        $array = ['foo', 'bar'];
        $this->assertEquals(Get::valueOrFail(1, $array), 'bar');
        $this->assertException(function () use ($array) {
            Get::valueOrFail(2, $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            Get::valueOrFail(2, $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnNestedArrayValues()
    {
        $array = ['foo', ['bar', 'foobar']];
        $this->assertEquals(Get::valueOrFail([1, 0], $array), 'bar');
        $this->assertException(function () use ($array) {
            Get::valueOrFail([1, 2], $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            Get::valueOrFail([1, 2], $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnNamedArrayValues()
    {
        $array = ['foo' => 'bar'];
        $this->assertEquals(Get::valueOrFail('foo', $array), 'bar');
        $this->assertException(function () use ($array) {
            Get::valueOrFail('bar', $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            Get::valueOrFail('bar', $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnNestedNamedArrayValues()
    {
        $array = ['foo' => ['bar' => 'foobar']];
        $this->assertEquals(Get::valueOrFail(['foo', 'bar'], $array), 'foobar');
        $this->assertException(function () use ($array) {
            Get::valueOrFail(['foo', 'foobar'], $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            Get::valueOrFail(['foo', 'foobar'], $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->assertException(function () use ($object) {
            Get::valueOrFail('bar', $object);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($object) {
            Get::valueOrFail('bar', $object, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnNestedObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->assertEquals(Get::valueOrFail(['foo', 'bar'], $object), 'foobar');
        $this->assertException(function () use ($object) {
            Get::valueOrFail(['foo', 'foobar'], $object);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($object) {
            Get::valueOrFail(['foo', 'foobar'], $object, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnMixedValues()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->assertEquals(Get::valueOrFail(['foo', 'bar'], $object), 'foobar');
        $this->assertException(function () use ($object) {
            Get::valueOrFail(['foo', 'foobar'], $object);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($object) {
            Get::valueOrFail(['foo', 'foobar'], $object, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');

        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->assertEquals(Get::valueOrFail(['foo', 'bar'], $array), 'foobar');
        $this->assertException(function () use ($array) {
            Get::valueOrFail(['foo', 'foobar'], $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            Get::valueOrFail(['foo', 'foobar'], $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldWorkWithNull()
    {
        $this->assertException(function () {
            Get::valueOrFail('foo', null);
        }, \OutOfBoundsException::class);
        $this->assertException(function () {
            Get::valueOrFail('foo', null, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
        $this->assertException(function () {
            Get::valueOrFail(['foo', 'bar'], null);
        }, \OutOfBoundsException::class);
        $this->assertException(function () {
            Get::valueOrFail(['foo', 'bar'], null, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetNormalizePathShouldBePublic()
    {
        $normalizePath = new \ReflectionMethod(Get::class, 'normalizePath');
        $this->assertTrue($normalizePath->isPublic());
    }

    public function testUsageExample()
    {
        $doe = \Schnittstabil\Get::value('name', $_REQUEST, 'John Doe');
        $this->assertEquals($doe, 'John Doe');

        $_REQUEST['name'] = 'Patrick Star';
        $patrick = \Schnittstabil\Get::value('name', $_REQUEST, 'John Doe');
        $this->assertEquals($patrick, 'Patrick Star');
    }

    public function testApiExample()
    {
        $array = ['zero', 'one', 'two'];
        $array['foo'] = new \stdClass();
        $array['foo']->bar = true;
        $array['un.usual'] = true;

        $this->assertEquals(\Schnittstabil\Get::value(1,              $array), 'one');
        $this->assertEquals(\Schnittstabil\Get::value('1',            $array), 'one');
        $this->assertEquals(\Schnittstabil\Get::value('foo.bar',      $array), true);
        $this->assertEquals(\Schnittstabil\Get::value(['foo', 'bar'], $array), true);
        $this->assertEquals(\Schnittstabil\Get::value(['un.usual'],   $array), true);
        $this->assertEquals(\Schnittstabil\Get::value('un.usual',     $array), null);
        $this->assertEquals(\Schnittstabil\Get::value(3,              $array), null);
        $this->assertEquals(\Schnittstabil\Get::value(3,              $array, 42), 42);
    }
}
