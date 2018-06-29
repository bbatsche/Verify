<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('test');

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony'                               => true,
        '@Symfony:risky'                         => true,
        '@PHPUnit43Migration:risky'              => true,
        'align_multiline_comment'                => ['comment_type' => 'all_multiline'],
        'array_indentation'                      => true,
        'array_syntax'                           => ['syntax' => 'short'],
        'binary_operator_spaces'                 => ['default' => 'align_single_space_minimal'],
        'class_attributes_separation'            => ['elements' => ['const', 'method', 'property']],
        'combine_consecutive_issets'             => true,
        'combine_consecutive_unsets'             => true,
        'comment_to_phpdoc'                      => true,
        'compact_nullable_typehint'              => true,
        'concat_space'                           => ['spacing'  => 'one'],
        'escape_implicit_backslashes'            => ['single_quoted' => true],
        'explicit_string_variable'               => true,
        'fully_qualified_strict_types'           => true,
        'heredoc_to_nowdoc'                      => true,
        'linebreak_after_opening_tag'            => true,
        'method_chaining_indentation'            => true,
        'multiline_comment_opening_closing'      => true,
        'multiline_whitespace_before_semicolons' => true,
        'no_alternative_syntax'                  => true,
        'no_extra_blank_lines'                   => [
            'tokens' => [
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
            ],
        ],
        'no_null_property_initialization'       => true,
        'no_php4_constructor'                   => true,
        'no_superfluous_elseif'                 => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else'                       => true,
        'no_useless_return'                     => true,
        'ordered_class_elements'                => ['sortAlgorithm' => 'alpha'],
        'ordered_imports'                       => ['importsOrder' => ['const', 'class', 'function']],
        'php_unit_strict'                       => true,
        'phpdoc_add_missing_param_annotation'   => ['only_untyped' => false],
        'phpdoc_order'                          => true,
        'phpdoc_types_order'                    => ['sort_algorithm' => 'none', 'null_adjustment' => 'always_last'],
        'psr0'                                  => true,
        'simplified_null_return'                => true,
        'single_line_comment_style'             => ['comment_types' => ['asterisk', 'hash']],
        'yoda_style'                            => false,
    ])
    ->setFinder($finder);
