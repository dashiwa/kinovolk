<?php

namespace Drupal\kstorage;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface FilmEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Film entity revision IDs for a specific Film entity.
   *
   * @param \Drupal\kstorage\Entity\FilmEntityInterface $entity
   *   The Film entity entity.
   *
   * @return int[]
   *   Film entity revision IDs (in ascending order).
   */
  public function revisionIds(FilmEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Film entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Film entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\kstorage\Entity\FilmEntityInterface $entity
   *   The Film entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(FilmEntityInterface $entity);

  /**
   * Unsets the language for all Film entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
