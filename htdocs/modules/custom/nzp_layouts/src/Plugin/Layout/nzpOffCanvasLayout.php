<?php

namespace Drupal\nzp_layouts\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Component\Uuid;

/**
 * Credit goes to npinos at https://github.com/npinos/drupal8-layouts.
*/


/**
 * Base class  for configuring Layout section properties.
 *
 * @internal
 *   Plugin classes are internal.
 */


 class nzpOffCanvasLayout extends LayoutDefault implements PluginFormInterface {


  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);


}



  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
            'oc_label' => '',
            'oc_position' => '',
             'uuid' => '',
      ];
}

   /**
   * {@inheritdoc}
   */
public function getFormId() {
  return 'oc_fieldset';
}

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();
   
        $form['oc_fieldset'] = [
          '#type' => 'container',
          '#attributes' => ['id' => 'oc-fieldset-wrapper'],

        ];

        $ocPositionOptions = [
          'left' => 'Left',
          'down' => 'Down',
          'up' => 'Up',
          'right' => 'Right',        
        ];

        $form['oc_position']= [
          '#type' => 'select',
          '#title' => t('oc Label'),
          '#options'=>  $ocPositionOptions,
          '#description' => t('Enter the offCanvas label'),
          '#default_value' => !empty($configuration['oc_position']) ? $configuration['oc_position'] : '',
        ];      

          $form['oc_label']= [
            '#type' => 'textfield',
            '#title' => t('oc Label'),
            '#description' => t('Enter the offCanvas label'),
            '#default_value' => !empty($configuration['oc_label']) ? $configuration['oc_label'] : '',
          ];      

          return $form;
         
  }





  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['oc_label'] = $form_state->getValue('oc_label');
    $this->configuration['oc_position'] = $form_state->getValue('oc_position');
    

    //generate a unique id for this tabs instance
    $uuid_service = \Drupal::service('uuid');
    $uuid = $uuid_service->generate();
    $this->configuration['uuid'] = $uuid;


  }

}
