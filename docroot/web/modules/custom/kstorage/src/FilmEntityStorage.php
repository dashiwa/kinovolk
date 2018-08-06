<?php

namespace Drupal\kstorage;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\kstorage\Entity\FilmEntityInterface;

/**
 * Defines the storage handler class for Film entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Film entity entities.
 *
 * @ingroup kstorage
 */
class FilmEntityStorage extends SqlContentEntityStorage implements FilmEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(FilmEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {film_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {film_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(FilmEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {film_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('film_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
