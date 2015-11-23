<?php

namespace Schnittstabil;

class GetTest extends \PHPUnit_Framework_TestCase
{
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

    public function testGetValueShouldReturnObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->assertEquals(Get::value('foo', $object), 'bar');
        $this->assertEquals(Get::value('bar', $object), null);
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

        $this->assertEquals(\Schnittstabil\Get::value(1, $array), 'one');
        $this->assertEquals(\Schnittstabil\Get::value(3, $array), null);
        $this->assertEquals(\Schnittstabil\Get::value(3, $array, 42), 42);

        $this->assertEquals(\Schnittstabil\Get::value(['foo', 'bar'], $array), true);
        $this->assertEquals(\Schnittstabil\Get::value(['foo', 'foobar'], $array), null);
        $this->assertEquals(\Schnittstabil\Get::value(['foo', 'foobar'], $array, 42), 42);
    }
}
