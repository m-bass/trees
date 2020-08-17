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
 * Provides a partial implementation for pre-order traversal on a tree.
 * A pre-order traversal on a tree performs the following steps:
 *   1) Process the current node
 *   2) Traverse the current node's children recursively from left to right.
 * A concrete subclass has to implement the processNode method from the ITreeTraversal interface.
 */

abstract class PreOrderTraversal implements INodeVisitor, ITreeTraversal
{
    public function visit(INode $node)
    {
        $this->processNode($node);

        foreach ($node->children() as $child) {
            $child->accept($this);
        }
    }
}
