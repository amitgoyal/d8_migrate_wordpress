<?php

namespace Drupal\migrate_wordpress\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Extract terms from Wordpress database.
 *
 * @MigrateSource(
 *   id = "terms"
 * )
 */
class Terms extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('terms', 't')
      ->fields('t', array_keys($this->termsFields()));
  }

  /**
   * Returns the User fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function termsFields() {
    $fields = array(
      'term_id' => $this->t('The term ID.'),
      'name' => $this->t('The name of the term.'),
    );
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->termsFields();
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Find parents for this row.
    $query = $this->select('term_taxonomy', 'tt')
      ->fields('tt', array('parent', 'term_id', 'taxonomy', 'description'))
      ->condition('term_id', $row->getSourceProperty('term_id'))
      ->execute()
      ->fetchAssoc();

    if (!empty($query)) {
      $row->setSourceProperty('parent', $query['parent']);
      $row->setSourceProperty('description', $query['description']);
      $row->setSourceProperty('vid', $query['taxonomy']);
    }

    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function bundleMigrationRequired() {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'term_id' => array(
        'type' => 'integer',
        'alias' => 't',
      ),
    );
  }

}
