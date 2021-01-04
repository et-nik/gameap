<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\VersionControl\GitMergeConflictSniff;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrailingCommaInMultilineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer;
use SlevomatCodingStandard\Sniffs\Classes\ParentCallSpacingSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UselessAliasSniff;
use SlevomatCodingStandard\Sniffs\PHP\UselessSemicolonSniff;
use SlevomatCodingStandard\Sniffs\Whitespaces\DuplicateSpacesSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
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

    $parameters->set(Option::SETS, [
        // run and fix, one by one
        // SetList::SPACES,
        // SetList::ARRAY,
        // SetList::DOCBLOCK,
        // SetList::CONTROL_STRUCTURES,
        // SetList::CLEAN_CODE,
        // SetList::PSR_12,
        // SetList::PHP_70,
        // SetList::PHP_71,
    ]);
};
