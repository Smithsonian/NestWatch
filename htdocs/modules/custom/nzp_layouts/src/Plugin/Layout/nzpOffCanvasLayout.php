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


 class nzpOffCanvasLayout extends LayoutDefault implements PluginFormInterface  {


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
            'oc_custom_id' => '',
            'oc_id_toggle' => 0,
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
          'top' => 'Top',
          'bottom' => 'Bottom',
          'right' => 'Right',        
        ];

        $form['oc_position']= [
          '#type' => 'select',
          '#title' => t('oc Label'),
          '#options'=>  $ocPositionOptions,
          '#description' => t('Enter the offCanvas label'),
          '#default_value' => !empty($configuration['oc_position']) ? $configuration['oc_position'] : '',
        ];      

        $form['oc_id_toggle']= [
          '#type' => 'checkbox',
          '#default_value' => FALSE,
          '#title' => t('Hide Label and use a Custom ID?'),
          '#default_value' => !empty($configuration['oc_id_toggle']) ? TRUE : FALSE,
          '#description' => t('Only check this if useful if you intend to use a custom trigger button rendered elsewhere'),
        ];

          $form['oc_label']= [
            '#type' => 'textfield',
            '#title' => t('oc Label'),
            '#description' => t('Enter the offCanvas label'),
            '#default_value' => !empty($configuration['oc_label']) ? $configuration['oc_label'] : '',
            '#states' => [
                'invisible' => [
                  ':input[name="layout_settings[oc_id_toggle]"]' => ['checked' => TRUE],
                ],
                'required' => [
                  ':input[name="layout_settings[oc_id_toggle]"]' => ['checked' => FALSE],

                ]
              ],
          ];

          $form['oc_custom_id']= [
            '#type' => 'textfield',
            '#title' => t('enter a custom Element ID.'),
            '#description' => t('DO NOT USE SPACES OR SPECIAL CHARACTERS.'),
            '#default_value' => !empty($configuration['oc_custom_id']) ? $configuration['oc_custom_id'] : '',
            '#states' => [
              'visible' => [
                ':input[name="layout_settings[oc_id_toggle]"]' => ['checked' => TRUE],
              ],
            ],
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
    $this->configuration['oc_custom_id'] = $form_state->getValue('oc_custom_id');
    $this->configuration['oc_id_toggle'] = $form_state->getValue('oc_id_toggle');
  }

}
