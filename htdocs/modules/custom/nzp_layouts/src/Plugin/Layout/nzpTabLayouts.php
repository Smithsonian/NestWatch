<?php

namespace Drupal\nzp_layouts\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;


/**
 * Credit goes to npinos at https://github.com/npinos/drupal8-layouts.
*/


/**
 * Base class  for configuring Layout section properties.
 *
 * @internal
 *   Plugin classes are internal.
 */


 class NzpTabLayouts extends LayoutDefault implements PluginFormInterface {
  /**
   * {@inheritdoc}
   */


  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

  
  }



  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
            'tab_title' => [],
        ];
}

 

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();

    $form['tab_number'] = [
        '#type' => 'textfield',
        '#attributes' => array(
            ' type' => 'number', // insert space before attribute name :)
        ),
        '#title' => 'number of tabs',
        '#required' => true,
        '#maxlength' => 3
    ];
    $num = $form_state->getValue('tab_number');
    // $tab_num = filter_var($num, FILTER_SANITIZE_NUMBER_INT);
    $tab_num = 3;
    // if (!empty($num)) {
        for ($i=0; $i < $tab_num; $i++) { 
            $form['tab_title'][$i] = [
                '#type' => 'textfield',
                '#title' => $this->t('Tab Title for Tab:' . $i),
                '#default_value' => $configuration['tab_title'],
            ];
        }
    // }



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
    
    $this->configuration['tab_title'] = $form_state->getValue('tab_title');
    
  }

}