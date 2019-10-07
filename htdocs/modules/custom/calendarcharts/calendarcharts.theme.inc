<?php

/**
 * @file
 * Theme for CalendarChart views.
 */
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
    $date_field[] = array_values($row->_entity->get($field)->getValue());
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




