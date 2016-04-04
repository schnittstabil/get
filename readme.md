# Get [![Build Status](https://travis-ci.org/schnittstabil/get.svg?branch=master)](https://travis-ci.org/schnittstabil/get) [![Coverage Status](https://coveralls.io/repos/schnittstabil/get/badge.svg?branch=master&service=github)](https://coveralls.io/github/schnittstabil/get?branch=master) [![Code Climate](https://codeclimate.com/github/schnittstabil/get/badges/gpa.svg)](https://codeclimate.com/github/schnittstabil/get)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c67798be-143a-432d-b11f-49210f437a33/big.png)](https://insight.sensiolabs.com/projects/c67798be-143a-432d-b11f-49210f437a33)

> Get nested array values and object properties.


## Install

```
$ composer require schnittstabil/get
```


## Usage

```php
require __DIR__.'/vendor/autoload.php';

use function Schnittstabil\Get\getValue;
use function Schnittstabil\Get\getValueOrFail;

echo 'Hello '.getValue('name', $_REQUEST, 'John Doe');
echo 'Hello '.getValueOrFail('PHP_AUTH_USER', $_SERVER, 'User is not authenticated.');
```


## API

### Schnittstabil\Get\getValue($path, $objectOrArray, $default = null)

Returns array values and object properties:

```php
use function Schnittstabil\Get\getValue;

$array = ['zero', 'one', 'two'];
$array['foo'] = new \stdClass();
$array['foo']->bar = true;
$array['un.usual'] = true;

getValue(1,              $array);  //=> 'one'
getValue('1',            $array);  //=> 'one'
getValue('foo.bar',      $array);  //=> true
getValue(['foo', 'bar'], $array);  //=> true
getValue(['un.usual'],   $array);  //=> true

// $default
getValue('un.usual', $array);      //=> null
getValue(3,          $array);      //=> null
getValue(3,          $array, 42);  //=> 42
```

### Schnittstabil\Get\getValueOrFail($path, $objectOrArray, $message = null)

Same as `Schnittstabil\Get\getValue`, but throws an `OutOfBoundsException`:

```php
use function Schnittstabil\Get\getValueOrFail;

getValueOrFail(3, $array);
//=> throws an OutOfBoundsException

getValueOrFail(3, $array, 'Error Message');
//=> throws a new OutOfBoundsException('Error Message')
```


## License

MIT © [Michael Mayer](http://schnittstabil.de)
