<?php
/**
 * This example shows how I would bring in a third-party validation library
 * into a regular Drupal form for more advanced form validation.
 */

namespace Drupal\code_samples\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Valitron\Validator;

class FormWithCustomValidations extends FormBase {
  /**
   * Logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $loggerFactory;

  /**
   * The Messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;


  /**
   * Constructor
   *
   * Passing in dependencies to the constructor.
   */
  public function __construct(LoggerChannelFactoryInterface $logger_factory, MessengerInterface $messenger) {
    $this->loggerFactory = $logger_factory;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_context_sample_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $formState) {
    $form['name_first'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      // etc...
    ];

    $form['name_last'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      // etc...
    ];

    $form['email'] = [
      '#type' => 'email',
      '#required' => TRUE,
      // etc...
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $formState) {
    $data = $formState->getValues();
    $validator = new Validator($data);
    $validator->rule('regex', 'name_first', '/^[a-zA-Z]+$/')
      ->message('First name: numbers or special characters not allowed');
    $validator->rule('email', 'email');
    $validator->validate();

    // If errors in validation, rebuild the form with error messages.
    $errors = $validator->errors();
    if (!empty($errors)) {
      foreach ($errors as $error) {
        // Add an error message to the message queue.
        $this->messenger->addError(implode(', ', $error));
        // Log the error.
        $this->loggerFactory('code_samples')
          ->error(get_class($this) . '::' . __FUNCTION__ . ' line ' . __LINE__ . ' - Server Validation Error: ' . implode(', ', $error));
      }
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $formState) {
    // Everything validated successfully.
    // Calls to APIs were made, success responses received, etc.
  }

}
