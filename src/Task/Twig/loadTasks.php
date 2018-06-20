<?php

namespace Heydon\Blt\Task\Twig;

use Heydon\Blt\Task\Twig;

trait loadTasks {

  /**
   * Load Twig
   *
   * @return Twig
   */
  protected function taskTwig() {
    return $this->task(Twig::class);
  }
}