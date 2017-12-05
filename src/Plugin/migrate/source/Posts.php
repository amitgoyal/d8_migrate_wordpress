<?php

namespace Drupal\migrate_wordpress\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Extract posts from Wordpress database.
 *
 * @MigrateSource(
 *   id = "posts"
 * )
 */
class Posts extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Select published posts.
    $query = $this->select('posts', 'p')
      ->fields('p', array_keys($this->postFields()))
      ->condition('post_status', 'publish', '=');

    return $query;
  }

  /**
   * Returns the Posts fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function postFields() {
    $fields = array(
      'id' => $this->t('Post ID'),
      'post_title' => $this->t('Title'),
      'post_content' => $this->t('Content'),
      'post_author' => $this->t('Authored by (uid)'),
      'post_type' => $this->t('Post type'),
    );
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->postFields();
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $post_type = $row->getSourceProperty('post_type');
    $type = $post_type == 'page' ? 'page' : 'article';
    $row->setSourceProperty('type', $type);

    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function bundleMigrationRequired() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function entityTypeId() {
    return 'node';
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'id' => array(
        'type' => 'integer',
        'alias' => 'p',
      ),
    );
  }

}
