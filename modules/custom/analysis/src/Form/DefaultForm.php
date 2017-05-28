<?php

namespace Drupal\analysis\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Class DefaultForm.
 *
 * @package Drupal\analysis\Form
 */
class DefaultForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'analysis.default',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'import_codes_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('analysis.default');
    $form['codes_file'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Codes file'),
      '#description' => $this->t('Select the xls file to import codes'),
      //'#default_value' => $config->get('codes_file'),
      '#required' => TRUE,
      '#upload_location' => 'public://upload/',
      '#upload_validators' => array(
        'file_validate_extensions' => array('xls xlsx csv'),
        // Pass the maximum file size in bytes
        //'file_validate_size' => array(MAX_FILE_SIZE*1024*1024),
      ),
    ];
    $form['import_date'] = [
      '#type' => 'date',
      '#title' => $this->t('import date'),
      '#description' => $this->t(''),
      '#default_value' => date('Y-m-d'),
      '#disabled' => TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //var_dump($form_state->getValue('codes_file'));
    $file = file_load($form_state->getValue('codes_file')[0]);
    //var_dump($file);
    print $uri = $file->getFileUri();
    if( !empty($uri) && file_exists(drupal_realpath($uri)) ) { 
      $handle = fopen(drupal_realpath($uri), "r");
      $i=0;
      // parse csv
      while ( ($data = fgetcsv($handle, 0, ';', '"')) !== FALSE ) {
        if ($i!=0){
          $code=$data["0"];
          $lib=$data["1"];
          //creat node of codes
          $node = Node::create([
            // The node entity bundle.
            'type' => 'results',
            'langcode' => 'fr',
            'created' => REQUEST_TIME,
            'changed' => REQUEST_TIME,
            // The user ID.
            'uid' => 1,
            'title' => "Analyse $code" ,
            'field_code' => $code,
            'field_label' => $lib,
            'field_max_value' => "max",
            'field_min_value' => "min",
          ]);
          $node->save();

        }
        
        $i++;
      }
      
      fclose($handle); 
    }
    parent::submitForm($form, $form_state);
    

    $this->config('analysis.default')
      ->set('codes_file', $uri)
      ->set('import_date', $form_state->getValue('import_date'))
      ->save();

    Drupal_set_message("Import codes terminé");
  }

}
