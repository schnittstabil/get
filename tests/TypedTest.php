<?php

namespace Schnittstabil\Get;

use Schnittstabil\Get;

/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class TypedTest extends \PHPUnit\Framework\TestCase
{
    public function typedShouldReturnStringValuesProvider()
    {
        return [
            ['unicorn', 'unicorn'],
            ['"true"', 'true'],
            ["'true'", 'true'],
            ['"false"', 'false'],
            ["'false'", 'false'],
            ['"yes"', 'yes'],
            ["'yes'", 'yes'],
            ['"no"', 'no'],
            ["'no'", 'no'],
            ['"on"', 'on'],
            ["'on'", 'on'],
            ['"off"', 'off'],
            ["'off'", 'off'],
            ['"0"', '0'],
            ["'0'", '0'],
            ['"1"', '1'],
            ["'1'", '1'],
            ['"0.0"', '0.0'],
            ["'0.0'", '0.0'],
            ['"1.0"', '1.0'],
            ["'1.0'", '1.0'],
            ['', ''],
        ];
    }

    /**
     * @dataProvider typedShouldReturnStringValuesProvider
     */
    public function testTypedShouldReturnStringValues($string, $resultString)
    {
        $this->assertSame(typed($string), $resultString);
    }

    public function testTypedShouldReturnIntValues()
    {
        $this->assertSame(typed('0'), 0);
        $this->assertSame(typed('1'), 1);
        $this->assertSame(typed('42'), 42);
    }

    public function testTypedShouldReturnFloatValues()
    {
        $this->assertSame(typed('0.0'), 0.0);
        $this->assertSame(typed('1.0'), 1.0);
        $this->assertSame(typed('66.6'), 66.6);
    }

    public function testTypedShouldReturnBoolValues()
    {
        $this->assertTrue(typed('true'));
        $this->assertTrue(typed('on'));
        $this->assertTrue(typed('yes'));

        $this->assertFalse(typed('false'));
        $this->assertFalse(typed('off'));
        $this->assertFalse(typed('no'));
    }

    public function testTypedShouldReturnNullValues()
    {
        $this->assertNull(typed(null));
        $this->assertNull(typed('null'));
    }

    public function testApiTypedExample()
    {
        $this->assertEquals(Get\typed('42'), 42);

        $this->assertTrue(Get\typed('true'));
        $this->assertTrue(Get\typed('yes'));
        $this->assertTrue(Get\typed('on'));

        $this->assertFalse(Get\typed('false'));
        $this->assertFalse(Get\typed('no'));
        $this->assertFalse(Get\typed('off'));

        // escaping
        $this->assertEquals(Get\typed('"true"'), 'true');
        $this->assertEquals(Get\typed("'true'"), 'true');
    }
}
