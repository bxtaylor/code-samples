<?php

/**
 * This is an example of a Service in Drupal 8.
 *
 * The purpose of this service is to store what step of a purchase path a user is on.
 *
 * For the purposes of this example, we assume that the user has to complete the purchase path steps in order.
 *
 * Therefore we can use the context to tell if a user ended up on purchase path step 3 without completing step 2
 * before it.
 *
 */

namespace Drupal\code_samples\Services;

/**
 * Site Context Service Interface.
 *
 * @package Drupal\code_samples
 */

interface SiteContextInterface {
  /**
   * Transitions the purchase path state to the step argument provided.
   *
   * @param string $step
   *   The step to transition to.
   */
  public function transitionToPurcahsePathStep($step);

  /**
   * Gets the stored purchase path value
   */
  public function getPurchasePathStep();

  /**
   * Gets the route of the active page.
   */
  public function getActiveRoute();

}

/** Implementation of SiteContextInterface */

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SiteContext.
 *
 * @package Drupal\code_samples
 */
class SiteContext implements SiteContextInterface {

  /**
   * Route service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;
  /**
   * The Private tempstore.
   *
   * @var \Drupal\Core\TempStore\PrivateTempStore
   */
  protected $tempstore;
  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Context data.
   *
   * @var array
   */
  protected $context;

  /**
   * CbanacContext constructor.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   Routematch.
   * @param \Drupal\Core\TempStore\PrivateTempStoreFactory $tempstore
   *   Tempstore.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   Request Stack.
   */
  public function __construct(RouteMatchInterface $route_match, PrivateTempStoreFactory $tempstore, RequestStack $request_stack) {
    $this->routeMatch = $route_match;
    $this->tempstore = $tempstore;
    $this->requestStack = $request_stack;
  }

  /**
   * @inheritdoc
   */
  public function transitionToPurchasePathStep($step) {
    $tempstore = $this->tempstore;
    $store = $tempstore->get('SiteContext');
    $store->set('purchase_path', $step);
  }

  /**
   * @inheritdoc
   */
  public function getPurchasePathStep() {
    $tempstore = $this->tempstore;
    $store = $tempstore->get('SiteContext');
    return $store->get('purchase_path');
  }

  /**
   * @inheritdoc
   */
  public function getActiveRoute() {
    return $this->routeMatch->getRouteName();
  }

}

/** Example usage in a Form */

namespace Drupal\code_samples\Form;

use Drupal\code_samples\Services\SiteContext;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form.
 */
class SampleForm extends FormBase {

  /**
   * The Site Context
   *
   * @var \Drupal\code_samples\Services\SiteContextInterface
   */
  protected $siteContext;

  /**
   * Constructor
   *
   * Passing in the dependency to the constructor.
   */
  public function __construct(SiteContext $siteContext) {
    $this->siteContext = $siteContext;
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
    // Validations go here.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $formState) {
    // Everything validated successfully.
    // Calls to APIs were made, success responses received, etc.
    // Update the purchase path context to the next step.
    $this->siteContext->transitionToPurchasePathStep('next_step');
  }

}
