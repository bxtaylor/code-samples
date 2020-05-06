<?php

namespace Drupal\global_site_notifications\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Global Site Notifications settings for this site.
 */
class GlobalSiteAlertSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'global_site_notifications_global_site_alert';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['global_site_notifications.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('global_site_notifications.settings');
    $form['enable_alert'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Global Site Alert'),
      '#description' => $this->t('Check this box to enable a global site alert that will display text below.'),
      '#default_value' => $config->get('enable_alert') ?? FALSE,
    ];

    $form['red_alert'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Go Code Red'),
      '#description' => $this->t('This checkbox turns the alert red and text white for high visibility.'),
      '#default_value' => $config->get('red_alert') ?? FALSE,
    ];

    $form['alert_disable_confirm_button'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Disable Confirmation Button'),
      '#description' => $this->t('This checkbox will remove the option to close the alert. The alert will persist on every page except the excluded pages below.'),
      '#default_value' => $config->get('alert_disable_confirm_button') ?? FALSE,
    ];

    $form['alert_position'] = [
      '#type' => 'select',
      '#title' => $this->t('Alert Position'),
      '#options' => [
        'top' => $this->t('Top'),
        'top_pushdown' => $this->t('Top (Pushdown)'),
        'top-left' => $this->t('Top - floating left'),
        'top-right' => $this->t('Top - floating right'),
        'bottom' => $this->t('Bottom'),
        'bottom-left' => $this->t('Bottom - floating left'),
        'bottom-right' => $this->t('Bottom - floating right'),
      ],
      '#default_value' => $config->get('alert_position') ?? 'top',
    ];

    $form['alert_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Global Alert Text'),
      '#default_value' => $config->get('alert_text') ?? NULL,
    ];

    $form['dismiss_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Dismiss Text'),
      '#description' => $this->t('The text to use for the dismiss button. Defaults to "Ok"'),
      '#default_value' => $config->get('dismiss_text') ?? NULL,
    ];

    $form['pages'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Pages to Hide Alert'),
      '#default_value' => $config->get('pages'),
      '#description' => $this->t("Specify pages by using their paths. Enter one path per line. The '*' character is a wildcard. An example path is %user-wildcard for every user page. %front is the front page.", [
        '%user-wildcard' => '/user/*',
        '%front' => '<front>',
      ]),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('enable_alert') && empty($form_state->getValue('alert_text'))) {
      $form_state->setErrorByName('alert_text', $this->t('When "Enable Global Site Alert" checkbox is checked, this field cannot be empty.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('global_site_notifications.settings')
      ->set('enable_alert', $form_state->getValue('enable_alert'))
      ->set('red_alert', $form_state->getValue('red_alert'))
      ->set('alert_text', $form_state->getValue('alert_text'))
      ->set('pages', $form_state->getValue('pages'))
      ->set('alert_disable_confirm_button', $form_state->getValue('alert_disable_confirm_button'))
      ->set('dismiss_text', $form_state->getValue('dismiss_text'))
      ->set('alert_position', $form_state->getValue('alert_position'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
