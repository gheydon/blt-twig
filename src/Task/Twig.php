<?php

namespace Heydon\Blt\Task;

use Heydon\Blt\Twig\Extension;
use Heydon\Robo\Task\Twig as TaskTwig;

class Twig extends TaskTwig {

  public function __construct() {
    array_unshift($this->extensions, new Extension());
  }

}