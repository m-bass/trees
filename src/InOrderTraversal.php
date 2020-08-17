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
 * Provides a partial implementation for in-order traversal on a tree.
 * A in-order traversal on a tree performs the following steps:
 *   1) Traverse the current node's left child recursively
 *   2) Process the current node
 *   3) Traverse the current node's right children recursively
 * A concrete subclass has to implement the processNode method from the ITreeTraversal interface.
 */

abstract class InOrderTraversal implements INodeVisitor, ITreeTraversal
{
    public function visit(INode $node)
    {
        if (isset($node->leftChild)) {
            $node->leftChild->accept($this) ;
        }

        $this->processNode($node);

        if (isset($node->leftChild)) {
            foreach ($node->leftChild->siblings() as $child) {
                $child->accept($this);
            }
        }
    }
}
