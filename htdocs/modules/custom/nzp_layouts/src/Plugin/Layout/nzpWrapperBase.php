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


abstract class nzpWrapperBase extends LayoutDefault implements PluginFormInterface {
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

    // Each of the variables below corresponds to custom arrays for each layout. 
    //These values are defined in the layout plugins for each layout (example: nzpTwoColLayouts.php). 
    $region_classes = array_keys($this->getRegionClasses());
    $container_classes = array_keys($this->getContainerClasses());
    $html_elements = array_keys($this->getHtmlElements());


    return [
      'region_classes' => array_shift($region_classes),
      'container_classes' => array_shift($container_classes),
      'html_container_elements' => array_shift($html_elements),
      'html_region_elements' => array_shift($html_elements),
    ];
  }

 

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {


    $configuration = $this->getConfiguration();
    $regions = $this->getPluginDefinition()->getRegions();

    $form['html_container_elements'] = [
      '#group' => 'HTML Elements',
      '#type' => 'select',
      '#options' =>  $this->getHtmlElements(),
      '#title' => $this->t('Wrapper Class'),
      '#description' => $this->t('Select a HTML Tag'),
      '#default_value' => !empty($configuration['html_container_elements']) ? $configuration['html_container_elements'] : 'div',
    ];

    $form['container_classes'] = [
      '#type' => 'select',
      '#options' =>  $this->getContainerClasses(),
      '#title' => $this->t('Wrapper Class'),
      '#description' => $this->t('Select a Wrapper Class'),
      '#default_value' => !empty($configuration['container_classes']) ? $configuration['container_classes'] : 'container',
    ];

    $form['region_classes'] = [
      '#type' => 'details',
      '#title' => $this->t('Region Options'),
      '#tree' => TRUE,
    ];

    $form['html_region_elements'] = [
      '#type' => 'details',
      '#title' => $this->t('HTML Element Options'),
      '#tree' => TRUE,
    ];

    foreach ($regions as $region_name => $region_definition) {

  
      $form['region_classes'][$region_name] = [
        '#type' => 'select',
        '#options' => $this->getRegionClasses(),
        '#title' => $this->t('Class for @region', ['@region' => $region_definition['label']]),
        '#default_value' => !empty($configuration['region_classes'][$region_name]) ? $configuration['region_classes'][$region_name] : 'gr',
      ];

      $form['html_region_elements'][$region_name]= [
        '#type' => 'select',
        '#options' => $this->getHtmlElements(),
        '#title' => $this->t('HTML Tag for @region', ['@region' => $region_definition['label']]),
        '#default_value' => !empty($configuration['html_region_elements'][$region_name]) ? $configuration['html_region_elements'][$region_name] : 'div',
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
    
    $this->configuration['container_classes'] = $form_state->getValue('container_classes');
    $this->configuration['html_container_elements'] = $form_state->getValue(['html_container_elements']);
    $this->configuration['html_region_elements'] = $form_state->getValue('html_region_elements');
    $this->configuration['region_classes'] = $form_state->getValue('region_classes');    
    

  }


  abstract protected function getContainerClasses();
  abstract protected function getRegionClasses();
  abstract protected function getHtmlElements();

}