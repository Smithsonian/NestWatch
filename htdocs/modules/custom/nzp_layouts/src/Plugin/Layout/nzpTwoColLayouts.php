<?php

namespace Drupal\nzp_layouts\Plugin\Layout;

use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;


/**
 * Credit goes to npinos at https://github.com/npinos/drupal8-layouts.
s */
class nzpTwoColLayouts extends LayoutDefault implements PluginFormInterface {


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
      'col-width' => [],
      'wrapper_class' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();
    $regions = $this->getPluginDefinition()->getRegions();

    $wrapper_options = [
      'container' => 'container',
      'container-fuid' => 'full-width',
    ];

    $col_options = [
      'gr' => 'flex',
      'gs1' => '1/12',
      'gs2' => '2/12',
      'gs3' => '3/12',
      'gs4' => '4/12',
      'gs5' => '5/12',
      'gs6' => '6/12',
      'gs7' => '7/12',
      'gs8' => '8/12',
      'gs9' => '9/12',
      'gs10' => '10/12',
      'gs11' => '11/12',
      'gs12' => '12/12',
    ];



    $form['wrapper_classes'] = [
      '#group' => 'Wrapper Class',
      '#type' => 'select',
      '#options' => $wrapper_options,
      '#title' => $this->t('Wrapper Class'),
      '#description' => $this->t('Select a Wrapper Class'),
      '#default_value' => !empty($configuration['wrapper_class']) ? $configuration['wrapper_class'] : 'container',
    ];

    foreach ($regions as $region_name => $region_definition) {
      $form['col_widths_form'][$region_name] = [
        '#type' => 'select',
        '#options' => $col_options,
        '#title' => $this->t('Width for @region', ['@region' => $region_definition['label']]),
        '#default_value' => !empty($configuration['col_width'][$region_name]) ? $configuration['col_width'][$region_name] : 'gr',
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
    // foreach (['col_width', 'wrapper_class', 'wrapper_id'] as $name) {
    //   $this->configuration[$name] = $this->configuration['attributes'][$name];
    //   unset($this->configuration['attributes'][$name]);
    // }
    $this->configuration['col_width'] = $form_state->getValue('col_widths_form');
    $this->configuration['wrapper_class'] = $form_state->getValue('wrapper_classes');
  }

}