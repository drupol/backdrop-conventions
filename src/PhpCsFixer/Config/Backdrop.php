<?php

namespace drupol\BackdropConventions\PhpCsFixer\Config;

/**
 * Class Backdrop.
 */
final class Backdrop extends AbstractBackdrop
{
  /**
   * @var string
   */
  public static $rules = '/../../../config/backdrop/phpcsfixer.rules.yml';

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'drupol/backdrop-conventions/backdrop';
  }
}
