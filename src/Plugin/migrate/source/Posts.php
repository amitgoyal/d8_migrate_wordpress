<?php

/**
 * @file
 * Contains \Drupal\migrate_wordpress\Plugin\migrate\source\Posts.
 */

namespace Drupal\migrate_wordpress\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate\Plugin\SourceEntityInterface;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Wordpress posts source from database.
 *
 * @MigrateSource(
 *   id = "posts"
 * )
 */
class Posts extends DrupalSqlBase implements SourceEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Select published posts.
    $query = $this->select('wp_posts', 'p')
      ->fields('p', array('id', 'post_title', 'post_content', 'post_author', 'post_type'))
      ->condition('post_status', 'publish', '=');

    //$query->condition('post_status', 'publish');

    if (isset($this->configuration['post_type'])) {
      $query->condition('post_type', $this->configuration['post_type']);
    }

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
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
  public function prepareRow(Row $row) {
    $post_type = $row->getSourceProperty('post_type');
    $type = $post_type == 'page' ? 'page' : 'article';
    $row->setSourceProperty('type', $type);

    //return parent::prepareRow($row);
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

}
