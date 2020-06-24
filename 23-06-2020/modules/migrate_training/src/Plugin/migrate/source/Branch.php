<?php

namespace Drupal\migrate_training\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the branch.
 *
 * @MigrateSource(
 *   id = "branch"
 * )
 */
class Branch extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('branch', 'g')
      ->fields('g', ['id', 'movie_id', 'name']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Branch ID'),
      'bank_id' => $this->t('Bank ID'),
      'name' => $this->t('Branch name'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'g',
      ],
    ];
  }
}