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
 * Provides a partial implementation for post-order traversal on a tree.
 * A post-order traversal on a tree performs the following steps:
 *   1) Traverse the current node's children recursively from left to right.
 *   2) Process the current node
 * A concrete subclass has to implement the processNode method from the ITreeTraversal interface.
 */

abstract class PostOrderTraversal implements INodeVisitor, ITreeTraversal
{
    public function visit(INode $node)
    {
        foreach ($node->children() as $child) {
            $child->accept($this);
        }

        $this->processNode($node);
    }
}
