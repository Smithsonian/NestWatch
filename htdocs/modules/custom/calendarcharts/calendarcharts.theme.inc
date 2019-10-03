<?php

/**
 * @file
 * Theme for CalendarChart views.
 */
function template_preprocess_views_view_tardis(&$variables) {
  // View options set by user.
  $options = $variables['view']->style_plugin->options;  

  // Update options for twig.
  $variables['options'] = $options;
}