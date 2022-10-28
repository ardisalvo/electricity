<?php
$finder = PhpCsFixer\Finder::create()
    ->exclude('somedir')
    ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
    ->in(__DIR__);


$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'phpdoc_scalar' => true,
    'array_indentation' => true,
    'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    'method_chaining_indentation' => true,
    'binary_operator_spaces' => true,
    'declare_strict_types' => false,
    //'strict_comparison' => true,
    'standardize_not_equals' => true,
    //'strict_param' => true,
    'concat_space' => ['spacing' => 'one'],
    'array_syntax' => ['syntax' => 'short'],
    'no_unused_imports' => true,
    'no_useless_else' => true,
    'blank_line_before_statement' => true,
    'whitespace_after_comma_in_array' => true,
])
    ->setFinder($finder);
