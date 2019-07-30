<?php

namespace Drupal\nzp_layouts\Plugin\Layout;

/**
 * Configurable twocol layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class nzpTwoColLayouts extends nzpWrapperBase {

  /**
   * {@inheritdoc}
   */

  protected function getContainerClasses() {
    return [
      'container' => 'container',
      'container-fuid' => 'full-width',
    ];
  }


  protected function getRegionClasses() {
    return [
      'gr' => 'flex',
      'gs1' => '1/12',
      'gs2' => '2/12',
      'gs3' => '3/12',
      'gs4' => '4/12',
      'gs5' => '5/12',
      'gs6' => '6/12',
      'gs7' => '7/12',
      'gs8' => '8/12',
      'gs9' => '9/12',
      'gs10' => '10/12',
      'gs11' => '11/12',
      'gs12' => '12/12',
    ];
  }

  protected function getHtmlElements() {
    return [
      'div' => 'Div',
      'section' => 'Section',
      'aside' => 'Aside',
    ];
  }

}
