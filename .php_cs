<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

$rules = [
    'psr0' => false,
    '@PSR2' => true,
    'short_array_syntax' => true,
    'phpdoc_order' => true,
    'ordered_imports' => true,
];

$cacheDir = getenv('TRAVIS') ? getenv('HOME') . '/.php-cs-fixer' : __DIR__;

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->finder($finder)
    ->setUsingCache(true)
    ->setCacheFile($cacheDir . '/.php_cs.cache');
