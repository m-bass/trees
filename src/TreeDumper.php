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

/**
 * Common implementation for dumping a tree.
 */
trait TreeDumper
{
    private $tree;
    private $expression;

    public function getTree()
    {
        return $this->tree;
    }

    public function setTree($tree)
    {
        $this->tree = $tree;
    }

    public function getExpression()
    {
        return $this->expression;
    }

    public function setExpression($expression)
    {
        $this->expression = $expression;
    }

    public function dumpExpression(INode $node)
    {
        $this->expression = '';
        $this->visit($node);
        return $this->expression ;
    }

    public function dumpTree(INode $node)
    {
        $this->tree = '';
        $this->visit($node);
        return $this->tree ;
    }
}
