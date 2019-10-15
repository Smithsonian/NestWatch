<?php

namespace Drupal\calendarcharts\Plugin\views\style;

use Drupal\core\form\FormStateInterface;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Style plugin to render CalendarCharts.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "calendarcharts_view_display",
 *   title = @Translation("Calendar Charts"),
 *   help = @Translation("Render contents in Calendar Charts view."),
 *   theme = "views_view_calendarcharts",
 *   display_types = { "normal" }
 * )
 */
class CalendarChartsDisplay extends StylePluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['canvasHeight'] = ['default' => '350'];
    $options['backgroundColor'] = ['default' => '#efefef'];
    $options['dateField'] = ['default' => ''];
    $options['cellColor'] = ['default' => '#09b'];
    $options['cellSize'] = ['default' => 10 ];
    $options['strokeOpacity'] = ['default' => 1];

  
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    // All selected fields.
    $field_names = $this->displayHandler->getFieldLabels();
    $entity_type = $this->view->getBaseEntityType()->id();

    $form['dateField'] = [
      '#title' => $this->t('Select Date Field'),
      '#type' => 'select',
      '#options' => $field_names,
      '#default_value' => (!empty($this->options['dateField'])) ? $this->options['dateField'] : '',
    ];

    $form['canvasHeight'] = [
      '#title' => $this->t('Canvas Height'),
      '#description' => t('Enter a canvas height'),
      '#type' => 'textfield',
      '#attributes' => [
        ' type' => 'number', // insert space before attribute name :)
      ],
      '#default_value' => (!empty($this->options['canvasHeight'])) ? $this->options['canvasHeight'] : '',
    ];
    
    $form['cellOptions'] = [
      '#type' => 'details',
      '#title' => t('Cell Display Options'),
      '#description' => t('Cell Display Options'),
    ];
    $form['cellColor'] = [
      '#title' => 'Select a cell color',
      '#type' => 'color',
      '#fieldset' => 'cellOptions',
      '#default_value' => (!empty($this->options['cellColor'])) ? $this->options['cellColor'] : '#09b',
    ];


    $form['cellSize'] = [
      '#type' => 'textfield',
      '#title' => 'Enter cell size',
      '#fieldset' => 'cellOptions',
      '#attributes' => [
        ' type' => 'number', // insert space before attribute name :)
      ],
      '#default_value' => (!empty($this->options['cellSize'])) ? $this->options['cellSize'] : '',
      ];

      $form['cellStroke'] = [
        '#type' => 'textfield',
        '#title' => 'Cell Stroke Size',
        '#fieldset' => 'cellOptions',
        '#attributes' => [
          ' type' => 'number', // insert space before attribute name :)
        ],
        '#default_value' => (!empty($this->options['cellStroke'])) ? $this->options['cellStroke'] : '',
        ];


  }
}

  