<?php

namespace Drupal\userdata\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'userdataBlock' block.
 *
 * @Block(
 *  id = "userdata_block",
 *  admin_label = @Translation("userdata block"),
 * )
 */
class userdataBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    ////$build = [];
    //$build['userdata_block']['#markup'] = 'Implement userdataBlock.';

    $form = \Drupal::formBuilder()->getForm('Drupal\userdata\Form\userdataForm');

    return $form;
  }

}
