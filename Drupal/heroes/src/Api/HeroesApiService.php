<?php

namespace Drupal\heroes\Api;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Http\ClientFactory;

/**
 * Class HeroesApiService.
 *
 * @package Drupal\heroes\Api
 */
class HeroesApiService {

  /**
   * HTTP Client factory.
   *
   * @var \Drupal\Core\Http\ClientFactory
   */
  protected $client;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * HeroApiService constructor.
   *
   * @param \Drupal\Core\Http\ClientFactory $http_client_factory
   *   Http client factory.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Config factory.
   */
  public function __construct(ClientFactory $http_client_factory, ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory->get('heroes');
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'https://superheroapi.com/',
    ]);
  }

  /**
   * Passes search string to character search endpoint.
   *
   * @param string $query
   *   The name of the superhero to search.
   *
   * @return array
   *   JSON decoded response from the Superhero API.
   */
  public function search(string $query) {
    $response = $this->client->get('/api/' . $this->configFactory->get('access_token') . '/search/' . $query);
    // @todo handle empty responses and errors here so the React app can catch errors correctly.
    return Json::decode($response->getBody());
  }

}
