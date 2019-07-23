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

        $i = 0;
        $tabs_field = $form_state->getValue('num_tabs');

        $form['#tree'] = TRUE;
        $form['tabs_fieldset'] = [
          '#type' => 'fieldset',
          '#title' => $this->t('Number of Tabs'),
          '#ajax' => TRUE,
          '#prefix' => '<div id="tabs-fieldset-wrapper">',
          '#suffix' => '</div>',
        ];
        
        $tabs_field = $form_state->setValue('num_tabs', 2);
        for ($i = 0; $i < $tabs_field; $i++) {
          $form['tabs_fieldset']['tab'][$i] = [
            '#type' => 'textfield',
            '#title' => t('Tab Label'),
            '#default_value' => !empty($configuration['tab_title'][$i]) ? $configuration['tab_title'][$i] : 'Tab 1',
          ];
        }
        $form['actions'] = [
          '#type' => 'actions',
        ];
        $form['tabs_fieldset']['actions']['add_tab'] = [
          '#type' => 'submit',
          '#value' => t('Add another Tab'),
          '#submit' => array('::addOne'),
          '#ajax' => [
            'callback' => '::addmoreCallback',
            'wrapper' => 'tabs-fieldset-wrapper',
          ],
        ];
        if ($tabs_field > 1) {
          $form['tabs_fieldset']['actions']['remove_tab'] = [
            '#type' => 'submit',
            '#value' => t('Remove a Tab'),
            '#submit' => array('::removeCallback'),
           '#ajax' => [
              'callback' => '::addmoreCallback',
              'wrapper' => 'tabs-fieldset-wrapper',
            ]
          ];
        }
        $form_state->setCached(FALSE);
   
    
        return $form;
      }
    
      public function getFormId() {
        return 'tabs_add_more';
      }
    
      public function addOne(array &$form, FormStateInterface $form_state) {
        $tabs_field = $form_state->get('num_tabs');
        $add_button = $tabs_field + 1;
        $form_state->set('num_tabs', $add_button);
        $form_state->setRebuild();
      }
    
      public function addmoreCallback(array &$form, FormStateInterface $form_state) {
        $tabs_field = $form_state->get('num_tabs');
        return $form['tabs_fieldset'];
      }
    
      public function removeCallback(array &$form, FormStateInterface $form_state) {
        $tabs_field = $form_state->get('num_tabs');
        if ($tabs_field > 1) {
          $remove_button = $tabs_field - 1;
          $form_state->set('num_tabs', $remove_button);
        }
       $form_state->setRebuild();
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
    $this->configuration['tab_title'] = $form_state->getValue(array('tabs_fieldset', 'tab'));
    
  }

}