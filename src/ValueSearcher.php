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
 * Traverses a tree n pre-order mode
 * and searches for a node with given VALUE.
 * Stops at the first occurence found.
 * @return INode
 *
 */
class ValueSearcher extends PreOrderTraversal
{
    private $FOUND = false;
    private $value = null;
    private $node = null;

    public function __construct($node)
    {
        $this->node = $node;
    }

    /**
     * The comparison relies on the behaviour of PHP's == comparison operator for objects.
     */
    public function processNode(INode $node)
    {
        if ($this->FOUND) {
            return;
        }
        if ($this->value == $node->getValue()) {
            $this->FOUND = true;
        }
    }

    public function search($value)
    {
        $this->value = $value;
        $this->visit($this->node);
        return $this->FOUND;
    }
}
