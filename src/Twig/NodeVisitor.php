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
    if ($node instanceof \Twig_Node_Print) {
      $n = $expr = $node->getNode('expr');
      $levels = [];
      $config = [];

      while ($n->hasNode('node')) {
        if ($n = $n->getNode('node')) {
          $levels[] = $n;
        }
      }

      /** @var \Twig_Node $n */
      if (($n = array_pop($levels)) && 'config' == $n->getAttribute('name')) {
        while ($n = array_pop($levels)) {
          if ($n->hasNode('attribute')) {
            $attr = $n->getNode('attribute');
            $config[] = $attr->getAttribute('value');
          }
          else {
            break;
          }
        }

        $line = $expr->getLine();
        $filter = $expr->getNode('filter');
        $arguments = $expr->getNode('arguments');
        $ret = new \Twig_Node_Print(
          new \Twig_Node_Expression_Filter(
            new \Twig_Node_Expression_GetAttr(
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
                $line),
              'method',
              $line
            ),
            $filter,
            $arguments,
            $line
          ),
          $line
        );

        return $ret;
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