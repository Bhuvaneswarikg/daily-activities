<?php

namespace Drupal\myform\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'MydataBlock' block.
 *
 * @Block(
 *  id = "myform_block",
 *  admin_label = @Translation("Myform block"),
 * )
 */
class MyformBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    ////$build = [];
    //$build['myform_block']['#markup'] = 'Implement MyformBlock.';

    $form = \Drupal::formBuilder()->getForm('Drupal\myform\Form\MyformForm');

    return $form;
  }

}
