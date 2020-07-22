<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('test')
    ->notName('function.php'); // no_superfluous_php_doc_tags does not play well with function.php
                               // basically treat rule & file as mutually exclusive; either have one or the other

return PhpCsFixer\Config::create()
    ->setRules([
        '@PHP70Migration'           => true,
        '@PHP70Migration:risky'     => true,
        '@PHPUnit60Migration:risky' => true,
        '@PhpCsFixer'               => true,
        '@PhpCsFixer:risky'         => true,
        'align_multiline_comment'   => ['comment_type' => 'phpdocs_like'],
        'backtick_to_shell_exec'    => true,
        'binary_operator_spaces'    => [
            'default'   => 'align_single_space_minimal',
            'operators' => ['||' => null, '&&' => null]
        ],
        'class_attributes_separation' => ['elements' => ['const', 'method', 'property']],
        'class_definition'            => [
            'single_item_single_line'             => true,
            'multi_line_extends_each_single_line' => true,
        ],
        'concat_space'                                     => ['spacing'  => 'one'],
        'date_time_immutable'                              => true,
        'final_static_access'                              => true,
        'global_namespace_import'                          => true,
        'linebreak_after_opening_tag'                      => true,
        'list_syntax'                                      => true,
        'mb_str_functions'                                 => true,
        'multiline_whitespace_before_semicolons'           => ['strategy' => 'no_multi_line'],
        'no_php4_constructor'                              => true,
        'no_superfluous_phpdoc_tags'                       => ['allow_mixed' => true],
        'no_unset_on_property'                             => false,
        'nullable_type_declaration_for_default_null_value' => true,
        'ordered_class_elements'                           => ['sortAlgorithm' => 'alpha'],
        'ordered_imports'                                  => ['imports_order' => ['const', 'class', 'function']],
        'phpdoc_line_span'                                 => ['const' => 'single', 'property' => 'single'],
        'phpdoc_no_empty_return'                           => false,
        'phpdoc_types_order'                               => ['sort_algorithm' => 'none', 'null_adjustment' => 'always_last'],
        'php_unit_test_case_static_method_calls'           => ['call_type' => 'this'],
        'php_unit_test_class_requires_covers'              => false,
        'psr0'                                             => ['dir' => 'src'],
        'self_static_accessor'                             => true,
        'simplified_null_return'                           => true,
        'yoda_style'                                       => false,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true);
