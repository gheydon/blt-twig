<?php

namespace Heydon\Blt\Twig;

class NodeVisitor extends \Twig_BaseNodeVisitor {

  /**
   * {@inheritdoc}
   */
  protected function doEnterNode(\Twig_Node $node, \Twig_Environment $env) {
    return $node;
  }

  /**
   * {@inheritdoc}
   */
  protected function doLeaveNode(\Twig_Node $node, \Twig_Environment $env) {
    if ($node instanceof \Twig_Node_Expression_GetAttr && $node->hasNode('node') && 'any' == $node->getAttribute('type')) {
      $n = $node;
      $levels = [
        $n,
      ];
      $config = [];

      while ($n->hasNode('node')) {
        if ($n = $n->getNode('node')) {
          $levels[] = $n;
        }
      }

      /** @var \Twig_Node $n */
      $n = array_pop($levels);
      if ($n instanceof \Twig_Node_Expression_Name && 'config' == $n->getAttribute('name')) {
        $alter = TRUE;
        while ($n = array_pop($levels)) {
          if ($n->hasNode('attribute')) {
            $attr = $n->getNode('attribute');
            $config[] = $attr->getAttribute('value');
          }
          else {
            $alter = FALSE;
            break;
          }
        }

        if ($alter) {
          $line = $node->getLine();
          return new \Twig_Node_Expression_GetAttr(
            new \Twig_Node_Expression_GetAttr(
              new \Twig_Node_Expression_Name('task', $line),
              new \Twig_Node_Expression_Constant('getConfig', $line),
              new \Twig_Node_Expression_Array([], $line),
              'method',
              $line
            ),
            new \Twig_Node_Expression_Constant('get', $line),
            new \Twig_Node_Expression_Array(
              [
                new \Twig_Node_Expression_Constant(0, $line),
                new \Twig_Node_Expression_Constant(implode('.', $config), $line)
              ],
              $line
            ),
            'method',
            $line
          );
        }
      }
      else if ($n instanceof \Twig_Node_Expression_Name && 'task' == $n->getAttribute('name')) {
        if ($node->hasNode('node')) {
          $n = $node->getNode('node');

          if ($n->hasNode('arguments')) {
            $args = $n->getNode('arguments');

            if ($args->hasNode(1) && $args->getNode(1)->hasAttribute('value')) {

              // Now we need to check the new argument.
              if ($node->hasNode('attribute') && $node->getNode('attribute')->hasAttribute('value')) {
                $args->getNode(1)->setAttribute('value', $args->getNode(1)->getAttribute('value') . '.' . $node->getNode('attribute')->getAttribute('value'));
                return $n;
              }
            }
          }
        }
      }
    }

    return $node;
  }

  /**
   * {@inheritdoc}
   */
  public function getPriority() {
    return 256;
  }
}