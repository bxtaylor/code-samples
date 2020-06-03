<?php

namespace Drupal\heroes\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\heroes\Api\HeroesApiService;
use Symfony\Component\HttpFoundation\JsonResponse;

class HeroesApiController extends ControllerBase {

  /**
   * The Superhero API Service.
   *
   * @var HeroesApiService $api
   */
  private $api;

  /**
   * HeroesApiController constructor.
   *
   * @param HeroesApiService $api
   *   API Service.
   */
  public function __construct(HeroesApiService $api) {
    $this->api = $api;
  }

  /**
   * @param ContainerInterface $container
   * @return HeroesApiController|static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('heroes.api')
    );
  }

  /**
   * Passes the name argument from the URL to the Superhero
   * API service.
   *
   * @param string $name
   *   The name passed from the URL argument.
   * @return JsonResponse
   *   JSON formatted response from the Superhero API.
   */
  public function search(string $name) {
    return new JsonResponse([
      'data' => $this->api->search($name),
      'method' => 'GET'
    ]);
  }

}
