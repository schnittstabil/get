<?php

namespace Schnittstabil\Get;

use Schnittstabil\Get\Fixtures\ArrayAccessObject;

/**
 * schnittstabil/sugared-phpunit depends on schnittstabil/get,
 * thus we need to run tests in seperate processes with new global state
 * to gather code coverage informations of this schnittstabil/get library,
 * and not the (global) schnittstabil/sugared-phpunit one.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class GetTest extends \PHPUnit\Framework\TestCase
{
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

    public function testGetValueOrFailWithArrayShouldReturn()
    {
        $this->assertEquals(getValueOrFail(1, ['foo', 'bar']), 'bar');
    }

    public function testGetValueOrFailWithArrayShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail(2, ['foo', 'bar']);
    }

    public function testGetValueOrFailWithArrayShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail(2, ['foo', 'bar'], 'MESSAGE');
    }

    public function testGetValueOrFailWithNestedArrayValueShouldReturn()
    {
        $this->assertEquals(getValueOrFail([1, 0], ['foo', ['bar', 'foobar']]), 'bar');
    }

    public function testGetValueOrFailWithNestedArrayValueShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail([1, 2], ['foo', ['bar', 'foobar']]);
    }

    public function testGetValueOrFailWithNestedArrayValueShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail([1, 2], ['foo', ['bar', 'foobar']], 'MESSAGE');
    }

    public function testGetValueOrFailWithNamedArrayValuesShouldReturn()
    {
        $this->assertEquals(getValueOrFail('foo', ['foo' => 'bar']), 'bar');
    }

    public function testGetValueOrFailWithNamedArrayValuesShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail('bar', ['foo' => 'bar']);
    }

    public function testGetValueOrFailWithNamedArrayValuesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail('bar', ['foo' => 'bar'], 'MESSAGE');
    }

    public function testGetValueOrFailWithNestedNamedArrayValuesShouldReturn()
    {
        $this->assertEquals(getValueOrFail(['foo', 'bar'], ['foo' => ['bar' => 'foobar']]), 'foobar');
    }

    public function testGetValueOrFailWithNestedNamedArrayValuesShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail(['foo', 'foobar'], ['foo' => ['bar' => 'foobar']]);
    }

    public function testGetValueOrFailWithNestedNamedArrayValuesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail(['foo', 'foobar'], ['foo' => ['bar' => 'foobar']], 'MESSAGE');
    }

    public function testGetValueOrFailWithObjectPropertiesShouldThrowOutOfBoundsException()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail('bar', $object);
    }

    public function testGetValueOrFailWithObjectPropertiesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail('bar', $object, 'MESSAGE');
    }

    public function testGetValueOrFailWithNestedObjectPropertiesShouldReturn()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->assertEquals(getValueOrFail(['foo', 'bar'], $object), 'foobar');
    }

    public function testGetValueOrFailWithNestedObjectPropertiesShouldThrowOutOfBoundsException()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail(['foo', 'foobar'], $object);
    }

    public function testGetValueOrFailWithNestedObjectPropertiesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail(['foo', 'foobar'], $object, 'MESSAGE');
    }

    public function testGetValueOrFailWithOAMixedValuesShouldReturn()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->assertEquals(getValueOrFail(['foo', 'bar'], $object), 'foobar');
    }

    public function testGetValueOrFailWithOAMixedValuesShouldThrowOutOfBoundsException()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail(['foo', 'foobar'], $object);
    }

    public function testGetValueOrFailWithOAMixedValuesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail(['foo', 'foobar'], $object, 'MESSAGE');
    }

    public function testGetValueOrFailWithAOMixedValuesShouldReturn()
    {
        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->assertEquals(getValueOrFail(['foo', 'bar'], $array), 'foobar');
    }

    public function testGetValueOrFailWithAOMixedValuesShouldThrowOutOfBoundsException()
    {
        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail(['foo', 'foobar'], $array);
    }

    public function testGetValueOrFailWithAOMixedValuesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail(['foo', 'foobar'], $array, 'MESSAGE');
    }

    public function testGetValueOrFailWithNullTargetShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail('foo', null);
    }

    public function testGetValueOrFailWithNullTargetShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail('foo', null, 'MESSAGE');
    }

    public function testGetValueOrFailWithArrayAndNullTargetShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        getValueOrFail(['foo', 'bar'], null);
    }

    public function testGetValueOrFailWithArrayAndNullTargetShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        getValueOrFail(['foo', 'bar'], null, 'MESSAGE');
    }

    public function testGetNormalizePathShouldBePublic()
    {
        $normalizePath = new \ReflectionMethod(Get::class, 'normalizePath');
        $this->assertTrue($normalizePath->isPublic());
    }

    public function testUsageExample()
    {
        $doe = getValue('name', $_REQUEST, 'John Doe');
        $this->assertEquals($doe, 'John Doe');

        $_REQUEST['name'] = 'Patrick Star';
        $patrick = getValue('name', $_REQUEST, 'John Doe');
        $this->assertEquals($patrick, 'Patrick Star');
    }

    public function testApiExample()
    {
        $array = ['zero', 'one', 'two'];
        $array['foo'] = new \stdClass();
        $array['foo']->bar = true;
        $array['un.usual'] = true;

        $this->assertEquals(getValue(1, $array), 'one');
        $this->assertEquals(getValue('1', $array), 'one');
        $this->assertEquals(getValue('foo.bar', $array), true);
        $this->assertEquals(getValue(['foo', 'bar'], $array), true);
        $this->assertEquals(getValue(['un.usual'], $array), true);
        $this->assertEquals(getValue('un.usual', $array), null);
        $this->assertEquals(getValue(3, $array), null);
        $this->assertEquals(getValue(3, $array, 42), 42);
    }
}
