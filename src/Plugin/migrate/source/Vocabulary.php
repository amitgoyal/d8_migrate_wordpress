<?php
/**
 * @file
 * Contains \Drupal\migrate_wordpress\Plugin\migrate\source\Vocabulary.
 */

namespace Drupal\migrate_wordpress\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate\Plugin\SourceEntityInterface;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Extracts users from Wordpress database.
 *
 * @MigrateSource(
 *   id = "vocabulary"
 * )
 */
class Vocabulary extends DrupalSqlBase implements SourceEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('wp_term_taxonomy', 'v')
      ->distinct()
      ->fields('v', array_keys($this->vocabFields()));
  }

  /**
   * Returns the User fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function vocabFields() {
    $fields = array(
      'taxonomy' => $this->t('Vocabulary'),
    );
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->vocabFields();
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $vocab = $row->getSourceProperty('taxonomy');
    $label = $vocab == 'category' ? 'Category' : 'Post Tags';
    $row->setSourceProperty('label', $label);

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
  public function entityTypeId() {
    return 'taxonomy_vocabulary';
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'taxonomy' => array(
        'type' => 'string',
        'alias' => 'v',
      ),
    );
  }

}
