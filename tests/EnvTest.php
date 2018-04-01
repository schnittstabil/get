<?php

namespace Schnittstabil\Get;

use putenv;
use Schnittstabil\Get;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class EnvTest extends \PHPUnit\Framework\TestCase
{
    public function testEnvShouldReturnNonTypedDefaultValues()
    {
        putenv('baz');
        $this->assertSame(env('baz'), null);
        $this->assertSame(env('baz', null), null);
        $this->assertSame(env('baz', 42), 42);
        $this->assertSame(env('baz', '42'), '42');

        $nullObject = new \stdClass;
        $this->assertSame(env('baz', $nullObject), $nullObject);
        $this->assertSame(env('baz', []), []);
    }

    public function testEnvShouldReturnNonTypedValues()
    {
        putenv('foo=42');
        $this->assertSame(env('foo', 42, false), '42');
    }

    public function testEnvShouldReturnTypedValues()
    {
        putenv('foo=42');
        $this->assertSame(env('foo'), 42);
    }

    public function testEnvOrFailShouldReturnNonTypedValues()
    {
        putenv('foo=42');
        $this->assertSame(envOrFail('foo', 42, false), '42');
    }

    public function testEnvOrFailShouldReturnTypedValues()
    {
        putenv('foo=42');
        $this->assertSame(envOrFail('foo'), 42);
    }

    public function testEnvOrFailShouldThrowOutOfBoundsException()
    {
        putenv('baz');
        $this->expectException(\OutOfBoundsException::class);
        envOrFail('baz');
    }

    public function testEnvOrFailShouldThrowOutOfBoundsExceptionWithMessage()
    {
        putenv('baz');
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('MESSAGE');
        envOrFail('baz', 'MESSAGE');
    }

    public function testEnvOrFailShouldThrowOutOfBoundsExceptionWithMessagecContainingEnv()
    {
        putenv('unicorns=unlimited');
        putenv('baz');
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessageRegExp('/^\W*unicorns\W+unlimited\W*$/m');
        envOrFail('baz');
    }

    public function testUsageExample()
    {
        $dbUser = Get\env('DB_USER', 'root');
        $this->assertEquals($dbUser, 'root');

        putenv('DB_PASS=unicorns are awsome');
        $dbPass = Get\envOrFail('DB_PASS', 'DB_PASS is not set');
        $this->assertEquals($dbPass, 'unicorns are awsome');
    }
}
