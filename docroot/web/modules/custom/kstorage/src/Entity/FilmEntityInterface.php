<?php

namespace Drupal\kstorage\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Film entity entities.
 *
 * @ingroup kstorage
 */
interface FilmEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Film entity name.
   *
   * @return string
   *   Name of the Film entity.
   */
  public function getName();

  /**
   * Sets the Film entity name.
   *
   * @param string $name
   *   The Film entity name.
   *
   * @return \Drupal\kstorage\Entity\FilmEntityInterface
   *   The called Film entity entity.
   */
  public function setName($name);

  /**
   * Gets the Film entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Film entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Film entity creation timestamp.
   *
   * @param int $timestamp
   *   The Film entity creation timestamp.
   *
   * @return \Drupal\kstorage\Entity\FilmEntityInterface
   *   The called Film entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Film entity published status indicator.
   *
   * Unpublished Film entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Film entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Film entity.
   *
   * @param bool $published
   *   TRUE to set this Film entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\kstorage\Entity\FilmEntityInterface
   *   The called Film entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Film entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Film entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\kstorage\Entity\FilmEntityInterface
   *   The called Film entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Film entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Film entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\kstorage\Entity\FilmEntityInterface
   *   The called Film entity entity.
   */
  public function setRevisionUserId($uid);

}
