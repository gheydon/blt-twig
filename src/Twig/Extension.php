<?php

namespace Heydon\Blt\Twig;

use Acquia\Blt\Robo\BltTasks;

class Extension extends \Twig_Extension {

  /**
   * @var \Acquia\Blt\Robo\BltTasks $task.
   */
  protected $task;

  public function __construct(BltTasks $task) {
    $this->task = $task;
  }

  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('config', [$this, 'getConfig']),
    ];
  }

  public function getConfig($key) {
    return $this->task->getConfig()->get($key);
  }
}
