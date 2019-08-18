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
    $ocLabelConfig = $configuration['oc_label'];
    $ocLabelFormstate = $form_state->get('ocLabelFormstate');

    if (!$form_state->has('ocLabelFormstate')) {
      $form_state->set('ocLabelFormstate', $ocLabelConfig);
    }
   

        $form['#tree'] =  TRUE;
        $form['oc_fieldset'] = array(
          '#type' => 'container',
          '#attributes' => ['id' => 'oc-fieldset-wrapper'],

        );

          $form['oc_fieldset']['oc_label']= [
            '#type' => 'textfield',
            '#title' => t('oc Label'),
            '#description' => t('Enter the offCanvas label'),
            '#default_value' => !empty($ocLabelConfig) ? $configuration['oc_label'] : '',
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
    $this->configuration['oc_label'] = $form_state->getValue(array('ocLabelFormstate'));

    //generate a unique id for this tabs instance
    $uuid_service = \Drupal::service('uuid');
    $uuid = $uuid_service->generate();
    $this->configuration['uuid'] = $uuid;


  }

}
