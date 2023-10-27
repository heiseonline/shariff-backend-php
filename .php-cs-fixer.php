<?php

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules(
        [
            // Basic ruleset is PSR 12
            '@PSR12'                          => true,
            // Short array syntax
            'array_syntax'                    => ['syntax' => 'short'],
            // Lists should not have a trailing comma like list($foo, $bar,) = ...
            'no_trailing_comma_in_singleline' => true,
            // Arrays on multiline should have a trailing comma
            'trailing_comma_in_multiline'     => ['elements' => ['arrays']],
            // Align elements in multiline array and variable declarations on new lines below each other
            'binary_operator_spaces'          => ['operators' => ['=>' => 'align_single_space_minimal', '=' => 'align']],
            // The "No break" comment in switch statements
            'no_break_comment'                => ['comment_text' => 'No break'],
            // Remove unused imports
            'no_unused_imports'               => true,
            // Classes from the global namespace should not be imported
            'global_namespace_import'         => ['import_classes' => false, 'import_constants' => false, 'import_functions' => false],
            // Alpha order imports
            'ordered_imports'                 => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'alpha'],
        ]
    )
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('tests/Fixtures')
            ->in(__DIR__ . '/src')
    );

return $config;
