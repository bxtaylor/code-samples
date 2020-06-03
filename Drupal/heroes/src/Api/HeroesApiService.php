<?php

namespace Drupal\heroes\Api;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Http\ClientFactory;

class HeroesApiService {

  /**
   * HTTP Client factory.
   *
   * @var ClientFactory $http_client_factory
   */
  protected $http_client_factory;

  /**
   * The config factory.
   *
   * @var ConfigFactoryInterface $configFactory
   */
  protected $configFactory;

  /**
   * HeroApiService constructor
   *
   * @param ClientFactory $http_client_factory
   *   Http client factory.
   * @param ConfigFactoryInterface $configFactory
   *   Config factory.
   */
  public function __construct(ClientFactory $http_client_factory, ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory->get('heroes');
    $this->http_client_factory = $http_client_factory->fromOptions([
      'base_uri' => 'https://superheroapi.com/'
    ]);
  }

  /**
   * Passes search string to character search endpoint.
   *
   * @param string $query
   *   The name of the superhero to search.
   * @return array
   *   JSON decoded response from the Superhero API.
   */
  public function search(string $query) {
    $response = $this->http_client_factory->get('/api/' . $this->configFactory->get('access_token') . '/search/' . $query);
    return Json::decode($response->getBody());
  }

}
