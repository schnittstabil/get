<?php

namespace Schnittstabil\Get;

require __DIR__.'/../vendor/autoload.php';

/*
 * schnittstabil/sugared-phpunit depends on schnittstabil/get which already loaded `src/functions.php`, thus we need to
 * remove all already defined functions and reload `src/functions.php` to gather the correct code coverage informations.
 */
if (function_exists('runkit_function_remove')) {
    if (function_exists('Schnittstabil\Get\getValue')) {
        runkit_function_remove('Schnittstabil\Get\getValue');
    }

    if (function_exists('Schnittstabil\Get\getValueOrFail')) {
        runkit_function_remove('Schnittstabil\Get\getValueOrFail');
    }

    require __DIR__.'/../src/functions.php';
}
