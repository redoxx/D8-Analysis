<?php

namespace Drupal\analysis\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ImportAnalysisCodesForm.
 *
 * @package Drupal\analysis\Form
 */
class ImportAnalysisCodesForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $import_analysis_codes = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $import_analysis_codes->label(),
      '#description' => $this->t("Label for the Import analysis codes."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $import_analysis_codes->id(),
      '#machine_name' => [
        'exists' => '\Drupal\analysis\Entity\ImportAnalysisCodes::load',
      ],
      '#disabled' => !$import_analysis_codes->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $import_analysis_codes = $this->entity;
    $status = $import_analysis_codes->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Import analysis codes.', [
          '%label' => $import_analysis_codes->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Import analysis codes.', [
          '%label' => $import_analysis_codes->label(),
        ]));
    }
    $form_state->setRedirectUrl($import_analysis_codes->toUrl('collection'));
  }

}
