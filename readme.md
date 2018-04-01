# Get [![Build Status](https://travis-ci.org/schnittstabil/get.svg?branch=master)](https://travis-ci.org/schnittstabil/get) [![Coverage Status](https://coveralls.io/repos/schnittstabil/get/badge.svg?branch=master&service=github)](https://coveralls.io/github/schnittstabil/get?branch=master)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c67798be-143a-432d-b11f-49210f437a33/big.png)](https://insight.sensiolabs.com/projects/c67798be-143a-432d-b11f-49210f437a33)

> Get nested array values and object properties.


## Install

```
$ composer require schnittstabil/get
```


## Usage

```php
require __DIR__.'/vendor/autoload.php';

use Schnittstabil\Get;

echo 'Hello '.Get\value('name', $_REQUEST, 'John Doe');
echo 'Hello '.Get\valueOrFail('PHP_AUTH_USER', $_SERVER, 'User is not authenticated.');

echo 'user:     '.Get\env('DB_USER', 'root');
echo 'password: '.Get\envOrFail('DB_PASS', 'DB_PASS is not set');
```


## API


### Schnittstabil\Get\value

```php
/**
 * Return array values and object properties.
 *
 * @param string|int|mixed[] $path    the path
 * @param object|array|null  $target  the target
 * @param mixed              $default default value if $path is not valid
 *
 * @return mixed the value determined by `$path` or otherwise `$default`
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
function value($path, $target, $default = null)
{/**/}
```

```php
use Schnittstabil\Get;

$array = ['zero', 'one', 'two'];
$array['foo'] = new \stdClass();
$array['foo']->bar = true;
$array['un.usual'] = true;

Get\value(1,              $array);  //=> 'one'
Get\value('1',            $array);  //=> 'one'
Get\value('foo.bar',      $array);  //=> true
Get\value(['foo', 'bar'], $array);  //=> true
Get\value(['un.usual'],   $array);  //=> true

// $default
Get\value('un.usual', $array);      //=> null
Get\value(3,          $array);      //=> null
Get\value(3,          $array, 42);  //=> 42
```


### Schnittstabil\Get\valueOrFail

> Same as `Schnittstabil\Get\value`, but throws an `OutOfBoundsException`.

```php
/**
 * Return array values and object properties.
 *
 * @param string|int|mixed[] $path    the path
 * @param object|array|null  $target  the target
 * @param mixed              $message exception message
 *
 * @throws \OutOfBoundsException if the `$path` does not determine a member of `$target`
 *
 * @return mixed the value determined by `$path`
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
function valueOrFail($path, $target, $message = null)
{/**/}
```

```php
use Schnittstabil\Get;

Get\valueOrFail(3, $array);
//=> throws an OutOfBoundsException

Get\valueOrFail(3, $array, 'Error Message');
//=> throws a new OutOfBoundsException('Error Message')
```


### Schnittstabil\Get\typed

```php
/**
 * Converts a string value to a PHP typed value.
 *
 * @param mixed  $value
 * @return mixed
 */
function typed($value)
{/**/}
```

```php
use Schnittstabil\Get;

Get\typed('42');
//=> int(42)

Get\typed('true');
Get\typed('yes');
Get\typed('on');
//=> bool(true)

Get\typed('false');
Get\typed('no');
Get\typed('off');
//=> bool(false)

/* escaping */
Get\typed('"true"');
Get\typed("'true'");
//=> string("true")
```


### Schnittstabil\Get\env

```php
/**
 * Gets the value of an environment variable.
 *
 * @param string $varname   the variable name
 * @param mixed  $default   default value if `$varname` is not valid
 * @param mixed  $typed     convert environment value to a PHP typed value
 * @param bool   $localOnly return only values of local environment variables
 *
 * @return mixed the environment value determined by `$varname` or otherwise `$default`
 */
function env($varname, $default = null, $typed = true, $localOnly = false)
{/**/}
```


### Schnittstabil\Get\envOrFail

```php
/**
 * Gets the value of an environment variable.
 *
 * @param string $varname   the variable name
 * @param mixed  $message   exception message
 * @param mixed  $typed     convert environment value to a PHP typed value
 * @param bool   $localOnly return only values of local environment variables
 *
 * @throws OutOfBoundsException if the `$varname` does not determine an environment value
 *
 * @return mixed the environment value determined by `$varname`
 */
function envOrFail($varname, $message = null, $typed = true, $localOnly = false)
{/**/}
```


## License

MIT © [Michael Mayer](http://schnittstabil.de)
