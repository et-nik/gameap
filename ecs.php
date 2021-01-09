<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\VersionControl\GitMergeConflictSniff;
use PhpCsFixer\Fixer\Alias\RandomApiMigrationFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrailingCommaInMultilineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use SlevomatCodingStandard\Sniffs\Classes\ParentCallSpacingSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\ReferenceThrowableOnlySniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UselessAliasSniff;
use SlevomatCodingStandard\Sniffs\PHP\UselessSemicolonSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\Strict\BlankLineAfterStrictTypesFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/app',
        __DIR__ . '/tests',
    ]);

    // Namespaces
    $services->set(UselessAliasSniff::class);
    $services->set(NoUnusedImportsFixer::class);
    $services->set(OrderedImportsFixer::class);
    $services->set(SingleBlankLineBeforeNamespaceFixer::class);

    $services->set(ParentCallSpacingSniff::class);
    $services->set(UselessSemicolonSniff::class);
    $services->set(NoWhitespaceBeforeCommaInArrayFixer::class);
    $services->set(GitMergeConflictSniff::class);
    $services->set(TrimArraySpacesFixer::class);

    $services->set(TrailingCommaInMultilineArrayFixer::class);
    $services->set(NoTrailingCommaInSinglelineArrayFixer::class);

    // PHP 7.1
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);
    $services->set(RandomApiMigrationFixer::class)
        ->call('configure', [[
            'mt_rand' => 'random_int',
            'rand' => 'random_int',
        ]]);
    $services->set(TernaryToNullCoalescingFixer::class);
    $services->set(BlankLineAfterStrictTypesFixer::class);
    $services->set(DeclareEqualNormalizeFixer::class);
    $services->set(ReturnTypeDeclarationFixer::class);
    $services->set(ReferenceThrowableOnlySniff::class);

    $services->set(ArrayIndentationFixer::class);
    $services->set(NoSpacesAfterFunctionNameFixer::class);

    $parameters->set(Option::SETS, [
        SetList::CONTROL_STRUCTURES,
        SetList::PSR_12,
        SetList::PHP_71,
        SetList::PHP_73_MIGRATION,
    ]);

    $services->set(BinaryOperatorSpacesFixer::class)
        ->call('configure', [[
            'align_double_arrow' => true,
            'align_equals'       => true,
        ]]);
};
