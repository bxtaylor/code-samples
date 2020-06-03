<?php

namespace Drupal\heroes\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class HeroesController.
 *
 * @package Drupal\heroes\Controller
 */
class HeroesController extends ControllerBase {

  /**
   * Returns render array for the ReactJS app.
   */
  public function content() {
    $build = [
      'app_container' => [
        '#markup' => '<div id="heroes-app"></div>',
      ],
      '#attached' => [
        'library' => [
          'heroes/heroes_app',
        ],
      ],
    ];
    return $build;
  }

}
