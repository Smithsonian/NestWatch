<?php

namespace Drupal\nzp_layouts\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * Class AddTab.
 */
class AddTab implements CommandInterface {

  /**
   * Render custom ajax command.
   *
   * @return ajax
   *   Command function.
   */
  public function render() {
    return [
      'command' => 'AddOne',
      'message' => 'My Awesome Message',
    ];
  }

}
