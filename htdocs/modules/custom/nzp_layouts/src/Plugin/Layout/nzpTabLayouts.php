<?php

namespace Drupal\nzp_layouts\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
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

  protected $number = 1;

  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);


}



  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
            'tab_title' => [],
             'num_tabs' =>  '',
      ];
}

   /**
   * {@inheritdoc}
   */
public function getFormId() {
  return 'tabs_fieldset';
}

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();

        $form['#tree'] =  TRUE;

        $form['tabs_fieldset'] = array(
          '#type' => 'container',
          '#attributes' => ['id' => 'tabs-fieldset-wrapper'], // CHECK THIS ID

        );
        
        for ($i = 0; $i < $this->number; $i++) {
          $form['tabs_fieldset']['tab_'. $i]= [
            '#type' => 'textfield',
            '#title' => t('Tab Label'),
            '#default_value' => !empty($configuration['tab_title'][$i]) ? $configuration['tab_title'][$i] : 'Tab 1',
          ];
        }


        $form['tabs_fieldset']['actions'] = [
          '#type' => 'actions',
        ];

        $form['tabs_fieldset']['actions']['add_tab'] = [
          '#type' => 'submit',
          '#value' => t('Add another Tab'),
          '#submit' => [$this, 'addOne'],
          '#ajax' => [
            'callback' => [$this, 'addmoreCallback'],
          ],
        ];
        if ($this->number > 1) {
          $form['tabs_fieldset']['actions']['remove_tab'] = [
            '#type' => 'submit',
            '#value' => t('Remove a Tab'),
            '#submit' => [$this, 'removeCallback'],
           '#ajax' => [
              'callback' => [$this, 'addmoreCallback'],
              'wrapper' => 'tabs-fieldset-wrapper',
              ]
           ];
        }
        return $form;
      }
    
   
      public function addmoreCallback($form, $form_state) {
        $number = $this->number++;
        return $form['tabs_fieldset'];
      }
    
      public function addOne(array &$form, FormStateInterface $form_state) {
        $this->number++;
        $form_state->setRebuild();
      }
    
      public function removeCallback(array &$form, FormStateInterface $form_state) {
        if ($this->number > 1) {
          $this->number--;
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
    $this->configuration['tab_title'] = $form_state->getValue(array('tabs_fieldset'));
    
  }

}
