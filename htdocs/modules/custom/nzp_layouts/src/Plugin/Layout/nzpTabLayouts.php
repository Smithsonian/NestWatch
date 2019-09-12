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


 class NzpTabLayouts extends LayoutDefault implements PluginFormInterface {


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
    $num_tabs_config = $configuration['num_tabs'];

    if (!$form_state->has('num_tabs')) {
      $form_state->set('num_tabs', $num_tabs_config);
    }
    $num_tabs = $form_state->get('num_tabs');
   

        $form['#tree'] =  TRUE;
        $form['tabs_fieldset'] = array(
          '#type' => 'container',
          '#attributes' => ['id' => 'tabs-fieldset-wrapper'],

        );

        for ($i = 0; $i < $num_tabs; $i++) {
          $form['tabs_fieldset']['tab'][$i]= [
            '#type' => 'textfield',
            '#title' => t('Tab Label'),
            '#description' => t('Enter Title for Tab: @tab_number', ['@tab_number' => $i+1]),
            '#default_value' => !empty($configuration['tab_title']['tab'][$i]) ? $configuration['tab_title']['tab'][$i] : '',
          ];
        }


        $form['tabs_fieldset']['actions'] = [
          '#type' => 'actions',
        ];
        if ($num_tabs < 6) {
        $form['actions']['add_tab'] = [
          '#type' => 'submit',
          '#value' => t('Add another Tab'),
          '#submit' => [[$this, 'addOne']],
          '#ajax' => [
            'callback' => [$this, 'addMoreCallback'],
            'wrapper' => 'tabs-fieldset-wrapper',
          ],
        ];
      }
        if ($num_tabs > 1) {
          $form['actions']['remove_tab'] = [
            '#type' => 'submit',
            '#value' => t('Remove a Tab'),
            '#submit' => [[$this, 'removeCallback']],
            '#ajax' => [
               'callback' => [$this, 'addMoreCallback'],
                'wrapper' => 'tabs-fieldset-wrapper',
                ]
           ];
        }
        return $form;
      }


      public function addMoreCallback(array$form, FormStateInterface $form_state) {
        return $form['layout_settings']['tabs_fieldset'];
  }

      public function addOne(array &$form, FormStateInterface $form_state) {
        $num_tabs = $form_state->get('num_tabs');
        if ($num_tabs < 6) {
        $add_tab = $num_tabs + 1;
        $form_state->set('num_tabs', $add_tab);
        }
        $form_state->setRebuild();
      }

      public function removeCallback(array &$form, FormStateInterface $form_state) {
        $num_tabs = $form_state->get('num_tabs');
        if ($num_tabs > 1) {
          $remove_tab = $num_tabs - 1;
          $form_state->set('num_tabs', $remove_tab);
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
    $this->configuration['num_tabs'] = $form_state->get('num_tabs');

  }

}
