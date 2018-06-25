<?php

namespace Heydon\Blt\Twig;

class Extension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getNodeVisitors() {
    return [
      new NodeVisitor(),
    ];
  }

}
