<?php
namespace Drupal\migrate_training\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for the banks.
 *
 * @MigrateSource(
 *   id = "banks"
 * )
 */
class Banks extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('banks', 'd')
      ->fields('d', ['id', 'name', 'description']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Bank ID'),
      'name' => $this->t('Bank Name'),
      'description' => $this->t('Bank Description'),
      'branch' => $this->t('Bank Branch'),
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
        'alias' => 'd',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $branch = $this->select('branch', 'g')
      ->fields('g', ['id'])
      ->condition('movie_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('branch', $branch);
    return parent::prepareRow($row);
  }
}