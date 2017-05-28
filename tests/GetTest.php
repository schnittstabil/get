<?php

namespace Schnittstabil\Get;

use Schnittstabil\Get;
use Schnittstabil\Get\Fixtures\ArrayAccessObject;

/**
 * schnittstabil/sugared-phpunit depends on schnittstabil/get,
 * thus we need to run tests in seperate processes with new global state
 * to gather code coverage informations of this schnittstabil/get library,
 * and not the (global) schnittstabil/sugared-phpunit one.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class GetTest extends \PHPUnit\Framework\TestCase
{
    public function testValueShouldReturnArrayValues()
    {
        $array = ['foo', 'bar'];
        $this->assertEquals(value(1, $array), 'bar');
        $this->assertEquals(value(2, $array), null);
        $this->assertEquals(value(2, $array, 42), 42);
    }

    public function testValueShouldReturnNestedArrayValues()
    {
        $array = ['foo', ['bar', 'foobar']];
        $this->assertEquals(value([1, 0], $array), 'bar');
        $this->assertEquals(value([1, 2], $array), null);
        $this->assertEquals(value([1, 2], $array, 42), 42);
    }

    public function testValueShouldReturnNamedArrayValues()
    {
        $array = ['foo' => 'bar'];
        $this->assertEquals(value('foo', $array), 'bar');
        $this->assertEquals(value('bar', $array), null);
        $this->assertEquals(value('bar', $array, 42), 42);
    }

    public function testValueShouldReturnNestedNamedArrayValues()
    {
        $array = ['foo' => ['bar' => 'foobar']];
        $this->assertEquals(value(['foo', 'bar'], $array), 'foobar');
        $this->assertEquals(value(['foo', 'foobar'], $array), null);
        $this->assertEquals(value(['foo', 'foobar'], $array, 42), 42);
    }

    public function testValueShouldReturnArrayAccessValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo', 'bar']);
        $this->assertEquals(value(1, $arrayAccesss), 'bar');
        $this->assertEquals(value(2, $arrayAccesss), null);
        $this->assertEquals(value(2, $arrayAccesss, 42), 42);
    }

    public function testValueShouldReturnNestedArrayAccessValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo', ['bar', 'foobar']]);
        $this->assertEquals(value([1, 0], $arrayAccesss), 'bar');
        $this->assertEquals(value([1, 2], $arrayAccesss), null);
        $this->assertEquals(value([1, 2], $arrayAccesss, 42), 42);
    }

    public function testValueShouldReturnNamedArrayAccessValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo' => 'bar']);
        $this->assertEquals(value('foo', $arrayAccesss), 'bar');
        $this->assertEquals(value('bar', $arrayAccesss), null);
        $this->assertEquals(value('bar', $arrayAccesss, 42), 42);
    }

    public function testValueShouldReturnNestedNamedArrayAccessValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo' => ['bar' => 'foobar']]);
        $this->assertEquals(value(['foo', 'bar'], $arrayAccesss), 'foobar');
        $this->assertEquals(value(['foo', 'foobar'], $arrayAccesss), null);
        $this->assertEquals(value(['foo', 'foobar'], $arrayAccesss, 42), 42);
    }

    public function testValueShouldReturnObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->assertEquals(value('foo', $object), 'bar');
        $this->assertEquals(value('bar', $object), null);
        $this->assertEquals(value('bar', $object, 42), 42);
    }

    public function testValueShouldReturnNestedObjectProperties()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->assertEquals(value(['foo', 'bar'], $object), 'foobar');
        $this->assertEquals(value(['foo', 'foobar'], $object), null);
        $this->assertEquals(value(['foo', 'foobar'], $object, 42), 42);
    }

    public function testValueShouldReturnMixedValues()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->assertEquals(value(['foo', 'bar'], $object), 'foobar');
        $this->assertEquals(value(['foo', 'foobar'], $object), null);
        $this->assertEquals(value(['foo', 'foobar'], $object, 42), 42);

        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->assertEquals(value(['foo', 'bar'], $array), 'foobar');
        $this->assertEquals(value(['foo', 'foobar'], $array), null);
        $this->assertEquals(value(['foo', 'foobar'], $array, 42), 42);
    }

    public function testValueShouldWorkWithNull()
    {
        $this->assertEquals(value('foo', null), null);
        $this->assertEquals(value('foo', null, 42), 42);
        $this->assertEquals(value(['foo', 'bar'], null), null);
        $this->assertEquals(value(['foo', 'bar'], null, 42), 42);
    }


    public function testValueShouldReturnArrayNullValues()
    {
        $array = ['foo' => null];
        $this->assertEquals(value('foo', $array, 'FAIL'), null);
    }

    public function testValueOrFailShouldReturnArrayNullValues()
    {
        $array = ['foo' => null];
        $this->assertEquals(valueOrFail('foo', $array, 'FAIL'), null);
    }

    public function testValueShouldReturnArrayAccessNullValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo' => null]);
        $this->assertEquals(value('foo', $arrayAccesss, 'FAIL'), null);
    }

    public function testValueOrFailShouldReturnArrayAccessNullValues()
    {
        $arrayAccesss = new ArrayAccessObject(['foo' => null]);
        $this->assertEquals(valueOrFail('foo', $arrayAccesss, 'FAIL'), null);
    }

    public function testValueShouldReturnObjectNullProperties()
    {
        $object = new \stdClass();
        $object->foo = null;
        $this->assertEquals(value('foo', $object, 'FAIL'), null);
    }

    public function testValueOrFailShouldReturnObjectNullProperties()
    {
        $object = new \stdClass();
        $object->foo = null;
        $this->assertEquals(valueOrFail('foo', $object, 'FAIL'), null);
    }

    public function testValueOrFailWithArrayShouldReturn()
    {
        $this->assertEquals(valueOrFail(1, ['foo', 'bar']), 'bar');
    }

    public function testValueOrFailWithArrayShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail(2, ['foo', 'bar']);
    }

    public function testValueOrFailWithArrayShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail(2, ['foo', 'bar'], 'MESSAGE');
    }

    public function testValueOrFailWithNestedArrayValueShouldReturn()
    {
        $this->assertEquals(valueOrFail([1, 0], ['foo', ['bar', 'foobar']]), 'bar');
    }

    public function testValueOrFailWithNestedArrayValueShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail([1, 2], ['foo', ['bar', 'foobar']]);
    }

    public function testValueOrFailWithNestedArrayValueShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail([1, 2], ['foo', ['bar', 'foobar']], 'MESSAGE');
    }

    public function testValueOrFailWithNamedArrayValuesShouldReturn()
    {
        $this->assertEquals(valueOrFail('foo', ['foo' => 'bar']), 'bar');
    }

    public function testValueOrFailWithNamedArrayValuesShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail('bar', ['foo' => 'bar']);
    }

    public function testValueOrFailWithNamedArrayValuesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail('bar', ['foo' => 'bar'], 'MESSAGE');
    }

    public function testValueOrFailWithNestedNamedArrayValuesShouldReturn()
    {
        $this->assertEquals(valueOrFail(['foo', 'bar'], ['foo' => ['bar' => 'foobar']]), 'foobar');
    }

    public function testValueOrFailWithNestedNamedArrayValuesShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail(['foo', 'foobar'], ['foo' => ['bar' => 'foobar']]);
    }

    public function testValueOrFailWithNestedNamedArrayValuesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail(['foo', 'foobar'], ['foo' => ['bar' => 'foobar']], 'MESSAGE');
    }

    public function testValueOrFailWithObjectPropertiesShouldThrowOutOfBoundsException()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail('bar', $object);
    }

    public function testValueOrFailWithObjectPropertiesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $object = new \stdClass();
        $object->foo = 'bar';
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail('bar', $object, 'MESSAGE');
    }

    public function testValueOrFailWithNestedObjectPropertiesShouldReturn()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->assertEquals(valueOrFail(['foo', 'bar'], $object), 'foobar');
    }

    public function testValueOrFailWithNestedObjectPropertiesShouldThrowOutOfBoundsException()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail(['foo', 'foobar'], $object);
    }

    public function testValueOrFailWithNestedObjectPropertiesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = 'foobar';
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail(['foo', 'foobar'], $object, 'MESSAGE');
    }

    public function testValueOrFailWithOAMixedValuesShouldReturn()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->assertEquals(valueOrFail(['foo', 'bar'], $object), 'foobar');
    }

    public function testValueOrFailWithOAMixedValuesShouldThrowOutOfBoundsException()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail(['foo', 'foobar'], $object);
    }

    public function testValueOrFailWithOAMixedValuesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $object = new \stdClass();
        $object->foo = ['bar' => 'foobar'];
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail(['foo', 'foobar'], $object, 'MESSAGE');
    }

    public function testValueOrFailWithAOMixedValuesShouldReturn()
    {
        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->assertEquals(valueOrFail(['foo', 'bar'], $array), 'foobar');
    }

    public function testValueOrFailWithAOMixedValuesShouldThrowOutOfBoundsException()
    {
        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail(['foo', 'foobar'], $array);
    }

    public function testValueOrFailWithAOMixedValuesShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $array = ['foo' => new \stdClass()];
        $array['foo']->bar = 'foobar';
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail(['foo', 'foobar'], $array, 'MESSAGE');
    }

    public function testValueOrFailWithNullTargetShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail('foo', null);
    }

    public function testValueOrFailWithNullTargetShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail('foo', null, 'MESSAGE');
    }

    public function testValueOrFailWithArrayAndNullTargetShouldThrowOutOfBoundsException()
    {
        $this->expectException(\OutOfBoundsException::class);
        valueOrFail(['foo', 'bar'], null);
    }

    public function testValueOrFailWithArrayAndNullTargetShouldThrowOutOfBoundsExceptionWithMessage()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/MESSAGE/');
        valueOrFail(['foo', 'bar'], null, 'MESSAGE');
    }

    public function testGetNormalizePathShouldBePublic()
    {
        $normalizePath = new \ReflectionMethod(Get\Get::class, 'normalizePath');
        $this->assertTrue($normalizePath->isPublic());
    }

    public function testUsageExample()
    {
        $doe = Get\value('name', $_REQUEST, 'John Doe');
        $this->assertEquals($doe, 'John Doe');

        $_REQUEST['name'] = 'Patrick Star';
        $patrick = Get\value('name', $_REQUEST, 'John Doe');
        $this->assertEquals($patrick, 'Patrick Star');
    }

    public function testApiValueExample()
    {
        $array = ['zero', 'one', 'two'];
        $array['foo'] = new \stdClass();
        $array['foo']->bar = true;
        $array['un.usual'] = true;

        $this->assertEquals(Get\value(1, $array), 'one');
        $this->assertEquals(Get\value('1', $array), 'one');
        $this->assertEquals(Get\value('foo.bar', $array), true);
        $this->assertEquals(Get\value(['foo', 'bar'], $array), true);
        $this->assertEquals(Get\value(['un.usual'], $array), true);
        $this->assertEquals(Get\value('un.usual', $array), null);
        $this->assertEquals(Get\value(3, $array), null);
        $this->assertEquals(Get\value(3, $array, 42), 42);
    }

    public function testApiValueOrFailExample()
    {
        $array = ['zero', 'one', 'two'];
        $array['foo'] = new \stdClass();
        $array['foo']->bar = true;
        $array['un.usual'] = true;

        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/3/');
        $this->expectExceptionMessageRegExp('/un\.usual/');
        Get\valueOrFail(3, $array);
    }

    public function testApiValueOrFailExampleWithMessage()
    {
        $array = ['zero', 'one', 'two'];
        $array['foo'] = new \stdClass();
        $array['foo']->bar = true;
        $array['un.usual'] = true;

        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/Error Message/');
        Get\valueOrFail(3, $array, 'Error Message');
    }

    public function testApiValueOrFailShouldReturnGetException()
    {
        try {
            Get\valueOrFail(3, null);
        } catch (Exception $e) {
            $this->assertInstanceOf(\Schnittstabil\Get\Exception::class, $e);
            $this->assertInstanceOf(\Schnittstabil\Get\OutOfBoundsException::class, $e);
            $this->assertInstanceOf(\OutOfBoundsException::class, $e);
            $this->assertSame($e->getPath(), [3]);
            $this->assertSame($e->getTarget(), null);
            return;
        }
        $this->fail();
    }

    public function testGetValueShouldBeSupported()
    {
        $this->assertEquals(getValue(1, ['foo', 'bar']), 'bar');
    }

    public function testGetValueShouldBeDeprecated()
    {
        $getValue = new \ReflectionFunction('Schnittstabil\Get\getValue');
        $this->assertRegExp('/^[\s]*\* @deprecated /m', $getValue->getDocComment());
    }

    public function testGetValueOrFailShouldBeSupported()
    {
        $this->assertEquals(getValueOrFail(1, ['foo', 'bar']), 'bar');
    }

    public function testGetValueOrFailShouldBeDeprecated()
    {
        $getValueOrFail = new \ReflectionFunction('Schnittstabil\Get\getValueOrFail');
        $this->assertRegExp('/^[\s]*\* @deprecated /m', $getValueOrFail->getDocComment());
    }
}
