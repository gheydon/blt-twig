<?php

namespace Heydon\Blt\Task\Twig;

use Acquia\Blt\Robo\BltTasks;
use Heydon\Blt\Task\Twig;

trait loadTasks {

  /**
   * Load Twig
   *
   * @return Twig
   */
  protected function taskTwig(BltTasks $task) {
    return $this->task(Twig::class, $task);
  }
}
