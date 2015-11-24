# Get [![Build Status](https://travis-ci.org/schnittstabil/get.svg?branch=master)](https://travis-ci.org/schnittstabil/get) [![Coverage Status](https://coveralls.io/repos/schnittstabil/get/badge.svg?branch=master&service=github)](https://coveralls.io/github/schnittstabil/get?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/schnittstabil/get/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/schnittstabil/get/?branch=master) [![Code Climate](https://codeclimate.com/github/schnittstabil/get/badges/gpa.svg)](https://codeclimate.com/github/schnittstabil/get)

> Get nested array values and object properties.


## Install

```
$ composer require schnittstabil/get
```


## Usage

```php
require __DIR__.'/vendor/autoload.php';

use Schnittstabil\Get;

echo 'Hello '.Get::value('name', $_REQUEST, 'John Doe');

echo 'Hello '.Get::valueOrFail('PHP_AUTH_USER', $_SERVER, 'User is not authenticated.');
```


## API

### Schnittstabil\Get::value($path, $objectOrArray, $default = null)

Returns array values and object properties:

```php
$array = ['zero', 'one', 'two'];
$array['foo'] = new \stdClass();
$array['foo']->bar = true;

\Schnittstabil\Get::value(1, $array)     //=> 'one'
\Schnittstabil\Get::value(3, $array)     //=> null
\Schnittstabil\Get::value(3, $array, 42) //=> 42

\Schnittstabil\Get::value(['foo', 'bar'], $array)        //=> true
\Schnittstabil\Get::value(['foo', 'foobar'], $array)     //=> null
\Schnittstabil\Get::value(['foo', 'foobar'], $array, 42) //=> 42
```

### Schnittstabil\Get::valueOrFail($path, $objectOrArray, $message = null)

Same as `Schnittstabil\Get::value`, but throws an `OutOfBoundsException`:

```php
\Schnittstabil\Get::value(3, $array)
//=> throws an OutOfBoundsException

\Schnittstabil\Get::value(3, $array, 'Error Message')
//=> throws a new OutOfBoundsException('Error Message')
```


## License

MIT © [Michael Mayer](http://schnittstabil.de)
