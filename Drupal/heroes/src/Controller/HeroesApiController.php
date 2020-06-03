<?php

namespace Drupal\heroes\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\heroes\Api\HeroesApiService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class HeroesApiController.
 *
 * @package Drupal\heroes\Controller
 */
class HeroesApiController extends ControllerBase {

  /**
   * The Superhero API Service.
   *
   * @var \Drupal\heroes\Api\HeroesApiService
   */
  private $api;

  /**
   * HeroesApiController constructor.
   *
   * @param \Drupal\heroes\Api\HeroesApiService $api
   *   API Service.
   */
  public function __construct(HeroesApiService $api) {
    $this->api = $api;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('heroes.api')
    );
  }

  /**
   * Passes name argument from URL to Superhero API service.
   *
   * @param string $name
   *   The name passed from the URL argument.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   JSON formatted response from the Superhero API.
   */
  public function search(string $name) {
    return new JsonResponse([
      'data' => $this->api->search($name),
      'method' => 'GET',
    ]);
  }

}
