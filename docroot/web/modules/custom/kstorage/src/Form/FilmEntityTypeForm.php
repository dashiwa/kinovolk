<?php

namespace Drupal\kstorage\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FilmEntityTypeForm.
 */
class FilmEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $film_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $film_entity_type->label(),
      '#description' => $this->t("Label for the Film entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $film_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\kstorage\Entity\FilmEntityType::load',
      ],
      '#disabled' => !$film_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $film_entity_type = $this->entity;
    $status = $film_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Film entity type.', [
          '%label' => $film_entity_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Film entity type.', [
          '%label' => $film_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($film_entity_type->toUrl('collection'));
  }

}
