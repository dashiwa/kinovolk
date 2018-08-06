<?php

namespace Drupal\kstorage\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Film entity type entity.
 *
 * @ConfigEntityType(
 *   id = "film_entity_type",
 *   label = @Translation("Film entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\kstorage\FilmEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\kstorage\Form\FilmEntityTypeForm",
 *       "edit" = "Drupal\kstorage\Form\FilmEntityTypeForm",
 *       "delete" = "Drupal\kstorage\Form\FilmEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\kstorage\FilmEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "film_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "film_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/kino/film_entity_type/{film_entity_type}",
 *     "add-form" = "/admin/structure/kino/film_entity_type/add",
 *     "edit-form" = "/admin/structure/kino/film_entity_type/{film_entity_type}/edit",
 *     "delete-form" = "/admin/structure/kino/film_entity_type/{film_entity_type}/delete",
 *     "collection" = "/admin/structure/kino/film_entity_type"
 *   }
 * )
 */
class FilmEntityType extends ConfigEntityBundleBase implements FilmEntityTypeInterface {

  /**
   * The Film entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Film entity type label.
   *
   * @var string
   */
  protected $label;

}
