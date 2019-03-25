<?php

namespace drupol\BackdropConventions\PhpCsFixer\Config;

use drupol\BackdropConventions\PhpCsFixer\Fixer\BlankLineBeforeEndOfClass;
use drupol\BackdropConventions\PhpCsFixer\Fixer\ControlStructureCurlyBracketsElseFixer;
use drupol\BackdropConventions\PhpCsFixer\Fixer\InlineCommentSpacerFixer;
use drupol\BackdropConventions\PhpCsFixer\Fixer\UppercaseConstantsFixer;
use PhpCsFixer\Config as PhpCsFixerConfig;
use PhpCsFixer\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Backdrop.
 */
abstract class AbstractBackdrop extends PhpCsFixerConfig implements Config
{
  /**
   * @var string
   */
  public static $rules = '/../../../config/backdrop/phpcsfixer.rules.yml';

  /**
   * AbstractBackdrop constructor.
   *
   * @param string $name
   *   The config name.
   */
  public function __construct($name = 'default') {
    parent::__construct($this->getName());

    $this->setRules($this->getCustomRules());
  }

  /**
   * {@inheritdoc}
   */
  public function getIndent() {
    return '  ';
  }

  /**
   * {@inheritdoc}
   */
  public function getLineEnding() {
    return "\n";
  }

  /**
   * {@inheritdoc}
   */
  public function getFinder() {
    return Finder::create()
      ->files()
      ->name('*.inc')
      ->name('*.install')
      ->name('*.module')
      ->name('*.profile')
      ->name('*.php')
      ->name('*.theme')
      ->ignoreDotFiles(true)
      ->ignoreVCS(true)
      ->exclude(['build', 'libraries', 'node_modules', 'vendor'])
      ->in($_SERVER['PWD']);
  }

  /**
   * {@inheritdoc}
   */
  public function alterCustomFixers(array &$fixers)
  {

  }

  /**
   * {@inheritdoc}
   */
  final public function getCustomFixers()
  {
    $fixers = parent::getCustomFixers();

    $fixers = array_merge($fixers, [
      new BlankLineBeforeEndOfClass($this->getIndent(), $this->getLineEnding()),
      new ControlStructureCurlyBracketsElseFixer($this->getIndent(), $this->getLineEnding()),
      new InlineCommentSpacerFixer(),
      new UppercaseConstantsFixer(),
    ]);

    // @todo: is this really required.
    $this->alterCustomFixers($fixers);

    return $fixers;
  }

  /**
   * Get the custom rules.
   *
   * @return array
   *   The rules.
   */
  private function getCustomRules() {
    $rules = parent::getRules();

    $classes = class_parents(static::class);
    array_unshift($classes, static::class);

    foreach (array_reverse(array_values($classes)) as $class) {
      if (!isset($class::$rules)) {
        continue;
      }

      $filename = __DIR__ . $class::$rules;

      if (!file_exists($filename)) {
        continue;
      }

      $parsed = (array) Yaml::parseFile($filename);
      $parsed['parameters'] = (array) $parsed['parameters'] + ['rules' => []];
      $rules = array_merge($rules, $parsed['parameters']['rules']);
    }

    return $rules;
  }
}
