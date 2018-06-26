<?php

namespace Heydon\Blt\Task;

use Acquia\Blt\Robo\BltTasks;
use Heydon\Blt\Twig\Extension;
use Heydon\Robo\Task\Twig as TaskTwig;
use Jasny\Twig\PcreExtension;

class Twig extends TaskTwig {

  public function __construct(BltTasks $task) {
    $this->context['task'] = $task;
    $this->context['config'] = $task->getConfig();
    $this->extensions = [
      new Extension($task),
      new PcreExtension(),
    ];
  }

}
