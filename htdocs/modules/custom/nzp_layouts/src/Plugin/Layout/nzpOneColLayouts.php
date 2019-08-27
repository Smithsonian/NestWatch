<?php

namespace Drupal\nzp_layouts\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;


/**
 * Credit goes to npinos at https://github.com/npinos/drupal8-layouts.
 * 
 */

class nzpOneColLayouts extends LayoutDefault implements PluginFormInterface {


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
      'wrappers' => [],
      'wrapper_classes' => '',
      'region_wrapper_classes' => [],
    ];
  }

  

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();
    $regions = $this->getPluginDefinition()->getRegions();

    $wrapper_options = [
      'div' => 'Div',
      'header' => 'Header',
      'footer' => 'Footer',
      'section' => 'Section',
      'aside' => 'Aside',
    ];

    $region_classes = [
      'container' => 'Container',
      'container-fluid' => 'Full Width',
      ];

    $form['region_wrappers'] = [
      '#group' => 'additional_settings',
      '#type' => 'details',
      '#title' => $this->t('Custom wrappers'),
      '#description' => $this->t('Choose a wrapper'),
      '#tree' => TRUE,
    ];

    $form['region_wrapper_classes'] = [
      '#group' => 'additional_settings',
      '#type' => 'details',
      '#title' => $this->t('Region wrapper classes'),
      '#description' => $this->t('Add classes for the region wrappers'),
      '#tree' => TRUE,
    ];

    foreach ($regions as $region_name => $region_definition) {
      $form['region_wrappers'][$region_name] = [
        '#type' => 'select',
        '#options' => $wrapper_options,
        '#title' => $this->t('Wrapper for @region', ['@region' => $region_definition['label']]),
        '#default_value' => !empty($configuration['wrappers'][$region_name]) ? $configuration['wrappers'][$region_name] : 'div',
      ];
      $form['region_wrapper_classes'][$region_name] = [
        '#type' => 'select',
        '#options' => $region_classes,
        '#title' => $this->t('Wrapper classes for @region', ['@region' => $region_definition['label']]),
        '#description' => $this->t('Add additional classes.'),
        '#default_value' => !empty($configuration['region_wrapper_classes'][$region_name]) ? $configuration['region_wrapper_classes'][$region_name] : '',
      ];
    }

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
    // $this->configuration['attributes'] = $form_state->getValue('attributes');
    // foreach (['wrapper_classes', 'wrapper_id'] as $name) {
    //   $this->configuration[$name] = $this->configuration['attributes'][$name];
    //   unset($this->configuration['attributes'][$name]);
    // }
    $this->configuration['wrappers'] = $form_state->getValue('region_wrappers');
    $this->configuration['region_wrapper_classes'] = $form_state->getValue('region_wrapper_classes');
  }

}