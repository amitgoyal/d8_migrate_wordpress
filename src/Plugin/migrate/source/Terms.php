<?php
/**
 * @file
 * Contains \Drupal\migrate_wordpress\Plugin\migrate\source\Terms.
 */

namespace Drupal\migrate_wordpress\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Extracts users from Wordpress database.
 *
 * @MigrateSource(
 *   id = "terms"
 * )
 */
class Terms extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('wp_terms', 'wpt')
      ->fields('wpt', array_keys($this->termsFields()));
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
    $query = $this->select('wp_term_taxonomy', 'wptt')
      ->fields('wptt', array('parent', 'term_id', 'taxonomy', 'description'))
      ->condition('term_id', $row->getSourceProperty('term_id'))
      ->execute()
      ->fetchAssoc();

    $row->setSourceProperty('parent', $query['parent']);
    $row->setSourceProperty('description', $query['description']);
    $row->setSourceProperty('vid', $query['taxonomy']);
    
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
        'alias' => 'wpt',
      ),
    );
  }

}
