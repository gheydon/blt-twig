<?php

namespace Heydon\Blt\Task;

use Acquia\Blt\Robo\BltTasks;
use Heydon\Blt\Twig\Extension;
use Heydon\Robo\Task\Twig as TaskTwig;

class Twig extends TaskTwig {

  public function __construct(BltTasks $task) {
    array_unshift($this->extensions, new Extension($task));
  }

}
