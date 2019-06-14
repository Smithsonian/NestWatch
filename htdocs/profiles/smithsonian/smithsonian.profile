<?php

/**
 * @file
 * Enables modules and site configuration for a smithsonian site installation.
 */

use Drupal\contact\Entity\ContactForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function smithsonian_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
//  $form['site_information']['site_name']['#default_value'] = 'Umami Food Magazine';
	$form['site_information']['site_mail']['#default_value'] = 'OCIO_Web_Admin@si.edu';
	$form['admin_account']['account']['mail']['#default_value'] = 'OCIO_Web_Admin@si.edu';
	$form['admin_account']['account']['name']['#default_value'] = 'sysadmin';
	$form['regional_settings']['site_default_country']['#default_value'] = 'US';
	$form['update_notifications']['enable_update_status_emails']['#default_value'] = 0;
}


