<?php

namespace Drupal\twigexample\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ws custom' block.
 *
 * @Block(
 *   id = "custom_block",
 *   admin_label = @Translation("Custom Block"),
 *
 * )
 */
class Custom extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
  // do something
    return array(
      '#title' => 'Title',
      '#description' => 'Description'
    );
  }
}