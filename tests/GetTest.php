<?php

namespace Schnittstabil\Get;

use Schnittstabil\Get\Fixtures\ArrayAccessObject;
use VladaHejda\AssertException;

/**
 * Get tests.
 */
class GetTest extends \PHPUnit_Framework_TestCase
{
    use AssertException;

    public function testGetValueShouldReturnArrayValues()
    {
        $array = ['foo', 'bar'];
        $this->assertEquals(getValue(1, $array), 'bar');
        $this->assertEquals(getValue(2, $array), null);
        $this->assertEquals(getValue(2, $array, 42), 42);
    }

    public function testGetValueShouldReturnNestedArrayValues()
    {
        $array = ['foo', ['bar', 'foobar']];
        $this->assertEquals(getValue([1, 0], $array), 'bar');
        $this->assertEquals(getValue([1, 2], $array), null);
        $this->assertEquals(getValue([1, 2], $array, 42), 42);
    }

    public function testGetValueShouldReturnNamedArrayValues()
    {
        $array = ['foo' => 'bar'];
        $this->assertEquals(getValue('foo', $array), 'bar');
        $this->assertEquals(getValue('bar', $array), null);
        $this->assertEquals(getValue('bar', $array, 42), 42);
    }

    public function testGetValueShouldReturnNestedNamedArrayValues()
    {
        $array = ['foo' => ['bar' => 'foobar']];
        $this->assertEquals(getValue(['foo', 'bar'], $array), 'foobar');
        $this->assertEquals(getValue(['foo', 'foobar'], $array), null);
        $this->assertEquals(getValue(['foo', 'foobar'], $array, 42), 42);
    }

    public function testGetValueShouldReturnArrayAccessValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo', 'bar']);
        $this->assertEquals(getValue(1, $arrayAccesss), 'bar');
        $this->assertEquals(getValue(2, $arrayAccesss), null);
        $this->assertEquals(getValue(2, $arrayAccesss, 42), 42);
    }

    public function testGetValueShouldReturnNestedArrayAccessValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo', ['bar', 'foobar']]);
        $this->assertEquals(getValue([1, 0], $arrayAccesss), 'bar');
        $this->assertEquals(getValue([1, 2], $arrayAccesss), null);
        $this->assertEquals(getValue([1, 2], $arrayAccesss, 42), 42);
    }

    public function testGetValueShouldReturnNamedArrayAccessValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo' => 'bar']);
        $this->assertEquals(getValue('foo', $arrayAccesss), 'bar');
        $this->assertEquals(getValue('bar', $arrayAccesss), null);
        $this->assertEquals(getValue('bar', $arrayAccesss, 42), 42);
    }

    public function testGetValueShouldReturnNestedNamedArrayAccessValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo' => ['bar' => 'foobar']]);
        $this->assertEquals(getValue(['foo', 'bar'], $arrayAccesss), 'foobar');
        $this->assertEquals(getValue(['foo', 'foobar'], $arrayAccesss), null);
        $this->assertEquals(getValue(['foo', 'foobar'], $arrayAccesss, 42), 42);
    }

    public function testGetValueShouldReturnObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->assertEquals(getValue('foo', $object), 'bar');
        $this->assertEquals(getValue('bar', $object), null);
        $this->assertEquals(getValue('bar', $object, 42), 42);
    }

    public function testGetValueShouldReturnNestedObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->assertEquals(getValue(['foo', 'bar'], $object), 'foobar');
        $this->assertEquals(getValue(['foo', 'foobar'], $object), null);
        $this->assertEquals(getValue(['foo', 'foobar'], $object, 42), 42);
    }

    public function testGetValueShouldReturnMixedValues()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->assertEquals(getValue(['foo', 'bar'], $object), 'foobar');
        $this->assertEquals(getValue(['foo', 'foobar'], $object), null);
        $this->assertEquals(getValue(['foo', 'foobar'], $object, 42), 42);

        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->assertEquals(getValue(['foo', 'bar'], $array), 'foobar');
        $this->assertEquals(getValue(['foo', 'foobar'], $array), null);
        $this->assertEquals(getValue(['foo', 'foobar'], $array, 42), 42);
    }

    public function testGetValueShouldWorkWithNull()
    {
        $this->assertEquals(getValue('foo', null), null);
        $this->assertEquals(getValue('foo', null, 42), 42);
        $this->assertEquals(getValue(['foo', 'bar'], null), null);
        $this->assertEquals(getValue(['foo', 'bar'], null, 42), 42);
    }

    public function testGetValueOrFailShouldReturnArrayValues()
    {
        $array = ['foo', 'bar'];
        $this->assertEquals(getValueOrFail(1, $array), 'bar');
        $this->assertException(function () use ($array) {
            getValueOrFail(2, $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            getValueOrFail(2, $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnNestedArrayValues()
    {
        $array = ['foo', ['bar', 'foobar']];
        $this->assertEquals(getValueOrFail([1, 0], $array), 'bar');
        $this->assertException(function () use ($array) {
            getValueOrFail([1, 2], $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            getValueOrFail([1, 2], $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnNamedArrayValues()
    {
        $array = ['foo' => 'bar'];
        $this->assertEquals(getValueOrFail('foo', $array), 'bar');
        $this->assertException(function () use ($array) {
            getValueOrFail('bar', $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            getValueOrFail('bar', $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnNestedNamedArrayValues()
    {
        $array = ['foo' => ['bar' => 'foobar']];
        $this->assertEquals(getValueOrFail(['foo', 'bar'], $array), 'foobar');
        $this->assertException(function () use ($array) {
            getValueOrFail(['foo', 'foobar'], $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            getValueOrFail(['foo', 'foobar'], $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->assertException(function () use ($object) {
            getValueOrFail('bar', $object);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($object) {
            getValueOrFail('bar', $object, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnNestedObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->assertEquals(getValueOrFail(['foo', 'bar'], $object), 'foobar');
        $this->assertException(function () use ($object) {
            getValueOrFail(['foo', 'foobar'], $object);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($object) {
            getValueOrFail(['foo', 'foobar'], $object, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldReturnMixedValues()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->assertEquals(getValueOrFail(['foo', 'bar'], $object), 'foobar');
        $this->assertException(function () use ($object) {
            getValueOrFail(['foo', 'foobar'], $object);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($object) {
            getValueOrFail(['foo', 'foobar'], $object, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');

        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->assertEquals(getValueOrFail(['foo', 'bar'], $array), 'foobar');
        $this->assertException(function () use ($array) {
            getValueOrFail(['foo', 'foobar'], $array);
        }, \OutOfBoundsException::class);
        $this->assertException(function () use ($array) {
            getValueOrFail(['foo', 'foobar'], $array, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetValueOrFailShouldWorkWithNull()
    {
        $this->assertException(function () {
            getValueOrFail('foo', null);
        }, \OutOfBoundsException::class);
        $this->assertException(function () {
            getValueOrFail('foo', null, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
        $this->assertException(function () {
            getValueOrFail(['foo', 'bar'], null);
        }, \OutOfBoundsException::class);
        $this->assertException(function () {
            getValueOrFail(['foo', 'bar'], null, 'MESSAGE');
        }, \OutOfBoundsException::class, null, 'MESSAGE');
    }

    public function testGetNormalizePathShouldBePublic()
    {
        $normalizePath = new \ReflectionMethod(Get::class, 'normalizePath');
        $this->assertTrue($normalizePath->isPublic());
    }

    public function testUsageExample()
    {
        $doe = \Schnittstabil\Get\getValue('name', $_REQUEST, 'John Doe');
        $this->assertEquals($doe, 'John Doe');

        $_REQUEST['name'] = 'Patrick Star';
        $patrick = \Schnittstabil\Get\getValue('name', $_REQUEST, 'John Doe');
        $this->assertEquals($patrick, 'Patrick Star');
    }

    public function testApiExample()
    {
        $array = ['zero', 'one', 'two'];
        $array['foo'] = new \stdClass();
        $array['foo']->bar = true;
        $array['un.usual'] = true;

        $this->assertEquals(\Schnittstabil\Get\getValue(1, $array), 'one');
        $this->assertEquals(\Schnittstabil\Get\getValue('1', $array), 'one');
        $this->assertEquals(\Schnittstabil\Get\getValue('foo.bar', $array), true);
        $this->assertEquals(\Schnittstabil\Get\getValue(['foo', 'bar'], $array), true);
        $this->assertEquals(\Schnittstabil\Get\getValue(['un.usual'], $array), true);
        $this->assertEquals(\Schnittstabil\Get\getValue('un.usual', $array), null);
        $this->assertEquals(\Schnittstabil\Get\getValue(3, $array), null);
        $this->assertEquals(\Schnittstabil\Get\getValue(3, $array, 42), 42);
    }
}
