<?php

namespace Drupal\drupal_assignment\Form;

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class ACFForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
	protected function getEditableConfigNames() {  
    return [
      'drupal_assignment.config_time_in_timezone',  
    ];  
  }  

  /**
   * {@inheritdoc}
   */
  public function getFormId() {  
    return 'config_time_in_timezone_form';  
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {  
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('drupal_assignment.config_time_in_timezone');

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => 'Country',
      '#default_value' => $config->get('country'),
      '#required' => TRUE,
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => 'City',
      '#default_value' => $config->get('city'),
      '#required' => TRUE,
    ];

    $timezones = [
      'America/Chicago' => 'America/Chicago',
      'America/New_York' => 'America/New_York',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London'
    ];

    $form['time_zone'] = [
      '#type' => 'select',
      '#title' => 'Timezone',
      '#options' => $timezones,
      '#default_value' => $config->get('time_zone'),
      '#required' => TRUE,
    ];

    return $form;
  }  

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);  

    $this->config('drupal_assignment.config_time_in_timezone')  
      ->set('country', $form_state->getValue('country'))  
      ->set('city', $form_state->getValue('city'))  
      ->set('time_zone', $form_state->getValue('time_zone'))  
      ->save();  
  }
}