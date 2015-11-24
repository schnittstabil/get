<?php
include 'vendor/autoload.php';

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in('Schnittstabil')
;

return new Sami($iterator, array(
    'title'                => 'Schnittstabil\Get API',
    'build_dir'            => __DIR__.'/doc',
    'cache_dir'            => __DIR__.'/build/cache',
    'default_opened_level' => 2,
));
