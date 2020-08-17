<?php
/*
 * This file is part of trees.
 *
 * (c) Marco Bosatta
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace trees;

class InOrderPrinter extends InOrderTraversal implements ITreeDumper
{
    use TreeDumper;
    public function processNode(INode $node)
    {
        $this->setTree($this->getTree() . str_repeat("..", $node->depth()) . $node->getValue() . PHP_EOL);
        $this->setExpression($this->getExpression() . $node->getValue() . ' ');
    }
}
