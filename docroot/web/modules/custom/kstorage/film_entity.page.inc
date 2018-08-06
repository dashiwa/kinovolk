<?php

/**
 * @file
 * Contains film_entity.page.inc.
 *
 * Page callback for Film entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Film entity templates.
 *
 * Default template: film_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_film_entity(array &$variables) {
  // Fetch FilmEntity Entity Object.
  $film_entity = $variables['elements']['#film_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
