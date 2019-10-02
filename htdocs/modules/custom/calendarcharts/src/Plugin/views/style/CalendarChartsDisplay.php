<?php

namespace Drupal\fullcalendar_view\Plugin\views\style;

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
 *   title = @Translation("Calendar Charts Display"),
 *   help = @Translation("Render contents in Calendar Charts view."),
 *   theme = "views_view_calendarcharts",
 *   display_types = { "normal" }
 * )
 */
class CalendarCharts extends StylePluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['canvasHeight'] = ['default' => '350'];
    $options['backgroundColor'] = ['default' => '#76a7fa'];
    $options['dateField'] = ['default' => ''];
    $options['cellOptions'] = [
      'default' => 
        [
          'cellColor' => 'red',
          'cellSize' => '10',
          'strokeWidth' =>  0.5,
          'strokeOpacity' => 1,
        ],
    ];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    // Remove the grouping setting.
    if (isset($form['grouping'])) {
      unset($form['grouping']);
    }

    // All selected fields.
    $field_names = $this->displayHandler->getFieldLabels();
    $entity_type = $this->view->getBaseEntityType()->id();
    $cell_colors = [  
        '#09b' => t('cyan'),
        '#09c' => t('green'),
        '#09d' => t('yellow'),
      ];

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
      '#type' => 'select',
      '#title' => 'Select a cell color',
      '#fieldset' => 'cellOptions',
      '#options' => $cell_colors, 
      '#default_value' => (!empty($this->options['cellColor'])) ? $this->options['cellColor'] : '',
      ];

    $form['cellSize'] = [
      '#type' => 'textfield',
      '#title' => 'Enter cell size',
      '#fieldset' => 'cellOptions',
      '#attributes' => [
        ' type' => 'number', // insert space before attribute name :)
      ],
      
      '#default_value' => (!empty($this->options['cellColor'])) ? $this->options['cellColor'] : '',
      ];
      $form['cellStroke'] = [
        '#type' => 'textfield',
        '#title' => 'Cell Stroke Size',
        '#fieldset' => 'cellOptions',
        '#attributes' => [
          ' type' => 'number', // insert space before attribute name :)
        ],
        
        '#default_value' => (!empty($this->options['cellColor'])) ? $this->options['cellColor'] : '',
        ];
    $form['cellColor'] = [
      '#type' => 'select',
      '#title' => 'Select a cell color',
      '#fieldset' => 'cellOptions',
      '#options' => $cell_colors, 
      '#default_value' => (!empty($this->options['cellColor'])) ? $this->options['cellColor'] : '',
      ];

    if (!isset($form_state->getUserInput()['style_options'])) {
      // Taxonomy color input boxes.
      $form['color_taxonomies'] = $this->taxonomyColorService->colorInputBoxs($this->options['vocabularies'], $this->options['color_taxonomies']);
    }
    // Content type colors.
    $form['color_bundle'] = [
      '#type' => 'details',
      '#title' => t('Colors for Bundle Types'),
      '#description' => t('Specify colors for each bundle type. If taxonomy color is specified, this settings would be ignored.'),
      '#fieldset' => 'colors',
    ];
    // All bundle types.
    $bundles = \Drupal::service('entity_type.bundle.info')->getBundleInfo($entity_type);
    // Options list.
    $bundlesList = [];
    foreach ($bundles as $id => $bundle) {
      $label = $bundle['label'];
      $bundlesList[$id] = $label;
      // Content type colors.
      $form['color_bundle'][$id] = [
        '#title' => $label,
        '#default_value' => isset($this->options['color_bundle'][$id]) ? $this->options['color_bundle'][$id] : '#3a87ad',
        '#type' => 'color',
      ];
    }
    $moduleHandler = \Drupal::service('module_handler');
    if ($moduleHandler->moduleExists('calendar_recurring_event')) {
      // Recurring event.
      $form['recurring'] = [
        '#type' => 'details',
        '#title' => t('Recurring event settings'),
          // '#description' =>  t('Settings for recurring event.'),.
      ];
      // Recurring business start time.
      $form['business_start'] = [
        '#type' => 'datetime',
        '#title' => t('Business start time'),
        '#description' => t('The time of a day when a recurring all day event starts. The recurring events whose start date include hour and minute will use their respective start time instead.'),
        '#fieldset' => 'recurring',
        '#default_value' => empty($this->options['business_start']) ? new DrupalDateTime('2018-02-24T08:00:00') : new DrupalDateTime($this->options['business_start']),
      // Hide date element.
        '#date_date_element' => 'none',
      // You can use text element here as well.
        '#date_time_element' => 'time',
        '#date_time_format' => 'H:i',
      ];
      // Recurring business end time.
      $form['business_end'] = [
        '#type' => 'datetime',
        '#title' => t('Business end time'),
        '#description' => t('The time of a day when a recurring event ends. The recurring events whose end date include hour and minute will use their respective end time instead.'),
        '#fieldset' => 'recurring',
        '#default_value' => empty($this->options['business_end']) ? new DrupalDateTime('2018-02-24T18:00:00') : new DrupalDateTime($this->options['business_end']),
      // Hide date element.
        '#date_date_element' => 'none',
      // You can use text element here as well.
        '#date_time_element' => 'time',
        '#date_time_format' => 'H:i',
      ];
    }
    // New event bundle type.
    $form['bundle_type'] = [
      '#title' => $this->t('Event bundle (Content) type'),
      '#description' => $this->t('The bundle (content) type of a new event. Once this is set, you can create a new event by double clicking a calendar entry.'),
      '#type' => 'select',
      '#options' => $bundlesList,
      '#default_value' => (!empty($this->options['bundle_type'])) ? $this->options['bundle_type'] : '',
    ];
    // Extra CSS classes.
    $form['classes'] = [
      '#type' => 'textfield',
      '#title' => t('CSS classes'),
      '#default_value' => (isset($this->options['classes'])) ? $this->options['classes'] : '',
      '#description' => t('CSS classes for further customization of this view.'),
    ];
  }

  /**
   * Options form submit handle function.
   *
   * @see \Drupal\views\Plugin\views\PluginBase::submitOptionsForm()
   */
  public function submitOptionsForm(&$form, FormStateInterface $form_state) {
    $options = &$form_state->getValue('style_options');
    $input_value = $form_state->getUserInput();
    $input_colors = isset($input_value['style_options']['color_taxonomies']) ? $input_value['style_options']['color_taxonomies'] : [];
    // Save the input of colors.
    foreach ($input_colors as $id => $color) {
      if (!empty($color)) {
        $options['color_taxonomies'][$id] = $color;
      }
    }
    // Datetime fields in Drupal 8 are stored as strings.
    if (isset($options['business_start'])) {
      $options['business_start'] = $options['business_start']->format(DATETIME_DATETIME_STORAGE_FORMAT);
    }
    if (isset($options['business_end'])) {
      $options['business_end'] = $options['business_end']->format(DATETIME_DATETIME_STORAGE_FORMAT);
    }

    parent::submitOptionsForm($form, $form_state);
  }

  /**
   * Taxonomy colors Ajax callback function.
   */
  public static function taxonomyColorCallback(array &$form, FormStateInterface $form_state) {
    $options = $form_state->getValue('style_options');
    $vid = $options['vocabularies'];
    $taxonomy_color_service = \Drupal::service('fullcalendar_view.taxonomy_color');

    if (isset($options['color_taxonomies'])) {
      $defaultValues = $options['color_taxonomies'];
    }
    else {
      $defaultValues = [];
    }
    // Taxonomy color boxes.
    $form['color_taxonomies'] = $taxonomy_color_service->colorInputBoxs($vid, $defaultValues, TRUE);

    return $form['color_taxonomies'];
  }

}
