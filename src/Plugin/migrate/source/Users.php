<?php
/**
 * @file
 * Contains \Drupal\migrate_wordpress\Plugin\migrate\source\Users.
 */

namespace Drupal\migrate_wordpress\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate\Plugin\SourceEntityInterface;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Extract users from Wordpress database.
 *
 * @MigrateSource(
 *   id = "users"
 * )
 */
class Users extends DrupalSqlBase implements SourceEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('wp_users', 'u')
      ->fields('u', array_keys($this->userFields()));
  }

  /**
   * Returns the User fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function userFields() {
    $fields = array(
      'id' => $this->t('User ID'),
      'user_login' => $this->t('Username'),
      'user_pass' => $this->t('Password'),
      'user_email' => $this->t('Email address'),
      'user_registered' => $this->t('Created time'),
    );
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->userFields();
    return $fields;
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
    return 'users';
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'id' => array(
        'type' => 'integer',
        'alias' => 'u',
      ),
    );
  }

}
