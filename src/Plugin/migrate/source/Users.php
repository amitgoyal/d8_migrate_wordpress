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
 * Extracts users from Wordpress database.
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
      ->fields('u', array_keys($this->baseFields()));
      //->condition('uid', 0, '>');
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $uid = $row->getSourceProperty('uid');

    // First Name
    /*$result = $this->getDatabase()->query(
      'SELECT pv.value FROM {profile_values} pv INNER JOIN {profile_fields} pf ON pf.fid = pv.fid WHERE pf.name = :field_name AND pv.uid = :uid', array(':uid' => $uid, ':field_name' => 'field_data_field_first_name')
    );
    foreach ($result as $record) {
      $row->setSourceProperty('first_name', $record->value);
    }

    // Last Name
    $result = $this->getDatabase()->query(
      'SELECT pv.value FROM {profile_values} pv INNER JOIN {profile_fields} pf ON pf.fid = pv.fid WHERE pf.name = :field_name AND pv.uid = :uid', array(':uid' => $uid, ':field_name' => 'field_data_field_last_name')
    );
    foreach ($result as $record) {
      $row->setSourceProperty('last_name', $record->value);
    }

    // Biography
    $result = $this->getDatabase()->query(
      'SELECT pv.value FROM {profile_values} pv INNER JOIN {profile_fields} pf ON pf.fid = pv.fid WHERE pf.name = :field_name AND pv.uid = :uid', array(':uid' => $uid, ':field_name' => 'field_data_field_biography')
    );
    foreach ($result as $record) {
      $row->setSourceProperty('biography', $record->value);
    }*/

  }

  /**
   * Returns the user base fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function baseFields() {
    $fields = array(
      'id' => $this->t('User ID'),
      'user_login' => $this->t('Username'),
      'user_pass' => $this->t('Password'),
      'user_email' => $this->t('Email address'),
      'user_registered' => $this->t('Created time'),
      /*'signature' => $this->t('Signature'),
      'signature_format' => $this->t('Signature format'),
      'created' => $this->t('Registered timestamp'),
      'access' => $this->t('Last access timestamp'),
      'login' => $this->t('Last login timestamp'),
      'status' => $this->t('Status'),
      'timezone' => $this->t('Timezone'),
      'language' => $this->t('Language'),
      'picture' => $this->t('Picture'),
      'init' => $this->t('Init'),*/
    );
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->baseFields();
    /*$fields['first_name'] = $this->t('First Name');
    $fields['last_name'] = $this->t('Last Name');
    $fields['biography'] = $this->t('Biography');*/
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
