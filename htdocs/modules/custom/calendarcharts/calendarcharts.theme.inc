<?php

/**
 * @file
 * Theme for CalendarChart views.
 */

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Component\Utility\NestedArray;

function template_preprocess_views_view_calendarcharts(&$variables) {
  // View options set by user.
  $view = $variables['view'];
  $style = $view->style_plugin;
  $options = $style->options;
  $variables['options'] = $options;
  $variables['style'] = $style;
  $rows = $variables['rows'];

  //grab the selected field and let's output it's results

  $field = $options['dateField'];

  foreach( $rows as $row ) {
    $a = $row->_entity->get($field)->getValue();
    $b = $a[0]['value'];
    $c = date('Y-m-d', $b);
    $date_field[] = $c;
  }

  $variables['dates'] = $date_field;

  static $view_count = -1;
  $view_count++;
  
  
  $variables['#attached']['library'][] = 'calendarcharts/calendarcharts';
  $variables['#attached']['drupalSettings']['calendarCharts'][$view_count] = [
    'data' => $date_field,
    'options' => $options,
  ];



}




