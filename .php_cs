<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(array(__DIR__.'/src'))
    ->exclude(array('Tests/Fixtures'))
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        '-unalign_double_arrow',
        '-unalign_equals',
        'align_double_arrow',
        'newline_after_open_tag',
        'ordered_use',
        'short_array_syntax',
        'php_unit_construct',
        'php_unit_strict',
        'linefeed',
        'eof_ending'
    ))
    ->setUsingCache(true)
    ->finder($finder);
