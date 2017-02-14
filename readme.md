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

use Schnittstabil\Get;

echo 'Hello '.Get\value('name', $_REQUEST, 'John Doe');
echo 'Hello '.Get\valueOrFail('PHP_AUTH_USER', $_SERVER, 'User is not authenticated.');
```


## API

### Schnittstabil\Get\value($path, $objectOrArray, $default = null)

Returns array values and object properties:

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

### Schnittstabil\Get\valueOrFail($path, $objectOrArray, $message = null)

Same as `Schnittstabil\Get\value`, but throws an `OutOfBoundsException`:

```php
use Schnittstabil\Get;

Get\valueOrFail(3, $array);
//=> throws an OutOfBoundsException

Get\valueOrFail(3, $array, 'Error Message');
//=> throws a new OutOfBoundsException('Error Message')
```


## License

MIT © [Michael Mayer](http://schnittstabil.de)
