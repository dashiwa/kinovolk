<?php

namespace Drupal\kstorage\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\kstorage\Entity\FilmEntityInterface;

/**
 * Class FilmEntityController.
 *
 *  Returns responses for Film entity routes.
 */
class FilmEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Film entity  revision.
   *
   * @param int $film_entity_revision
   *   The Film entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($film_entity_revision) {
    $film_entity = $this->entityManager()->getStorage('film_entity')->loadRevision($film_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('film_entity');

    return $view_builder->view($film_entity);
  }

  /**
   * Page title callback for a Film entity  revision.
   *
   * @param int $film_entity_revision
   *   The Film entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($film_entity_revision) {
    $film_entity = $this->entityManager()->getStorage('film_entity')->loadRevision($film_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $film_entity->label(), '%date' => format_date($film_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Film entity .
   *
   * @param \Drupal\kstorage\Entity\FilmEntityInterface $film_entity
   *   A Film entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(FilmEntityInterface $film_entity) {
    $account = $this->currentUser();
    $langcode = $film_entity->language()->getId();
    $langname = $film_entity->language()->getName();
    $languages = $film_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $film_entity_storage = $this->entityManager()->getStorage('film_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $film_entity->label()]) : $this->t('Revisions for %title', ['%title' => $film_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all film entity revisions") || $account->hasPermission('administer film entity entities')));
    $delete_permission = (($account->hasPermission("delete all film entity revisions") || $account->hasPermission('administer film entity entities')));

    $rows = [];

    $vids = $film_entity_storage->revisionIds($film_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\kstorage\FilmEntityInterface $revision */
      $revision = $film_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $film_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.film_entity.revision', ['film_entity' => $film_entity->id(), 'film_entity_revision' => $vid]));
        }
        else {
          $link = $film_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.film_entity.translation_revert', ['film_entity' => $film_entity->id(), 'film_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.film_entity.revision_revert', ['film_entity' => $film_entity->id(), 'film_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.film_entity.revision_delete', ['film_entity' => $film_entity->id(), 'film_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['film_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
