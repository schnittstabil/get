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
    public function testTypedShouldReturnStringValues()
    {
        $this->assertSame(typed('unicorn'), 'unicorn');

        $this->assertSame(typed('"true"'), 'true');
        $this->assertSame(typed("'true'"), 'true');

        $this->assertSame(typed('"false"'), 'false');
        $this->assertSame(typed("'false'"), 'false');

        $this->assertSame(typed('"yes"'), 'yes');
        $this->assertSame(typed("'yes'"), 'yes');

        $this->assertSame(typed('"no"'), 'no');
        $this->assertSame(typed("'no'"), 'no');

        $this->assertSame(typed('"on"'), 'on');
        $this->assertSame(typed("'on'"), 'on');

        $this->assertSame(typed('"off"'), 'off');
        $this->assertSame(typed("'off'"), 'off');

        $this->assertSame(typed('"0"'), '0');
        $this->assertSame(typed("'0'"), '0');

        $this->assertSame(typed('"1"'), '1');
        $this->assertSame(typed("'1'"), '1');

        $this->assertSame(typed('"0.0"'), '0.0');
        $this->assertSame(typed("'0.0'"), '0.0');

        $this->assertSame(typed('"1.0"'), '1.0');
        $this->assertSame(typed("'1.0'"), '1.0');

        $this->assertSame(typed(''), '');
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
        $this->assertSame(typed('true'), true);
        $this->assertSame(typed('on'), true);
        $this->assertSame(typed('yes'), true);

        $this->assertSame(typed('false'), false);
        $this->assertSame(typed('off'), false);
        $this->assertSame(typed('no'), false);
    }

    public function testTypedShouldReturnNullValues()
    {
        $this->assertSame(typed(null), null);
        $this->assertSame(typed('null'), null);
    }

    public function testApiTypedExample()
    {
        $this->assertEquals(Get\typed('42'), 42);

        $this->assertEquals(Get\typed('true'), true);
        $this->assertEquals(Get\typed('yes'), true);
        $this->assertEquals(Get\typed('on'), true);

        $this->assertEquals(Get\typed('false'), false);
        $this->assertEquals(Get\typed('no'), false);
        $this->assertEquals(Get\typed('off'), false);

        // escaping
        $this->assertEquals(Get\typed('"true"'), 'true');
        $this->assertEquals(Get\typed("'true'"), 'true');
    }
}
