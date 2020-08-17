<?php

namespace trees;

/**
 * Provides a partial implementation for pre-post-order traversal on a tree.
 * A pre-post-order traversal on a tree performs the following steps:
 *   1) pre-process the current node
 *   2) Traverse the current node's children recursively from left to right.
 *   3) post-process the current node
 * A concrete subclass has to implement the preProcessNode
 * and the postProcessNode methods.
 */

abstract class PrePostOrderTraversal implements INodeVisitor
{
    public function visit(INode $node)
    {
        $this->preProcessNode($node);

        foreach ($node->children() as $child) {
            $child->accept($this);
        }

        $this->postProcessNode($node);
    }

    abstract public function preProcessNode(INode $node);

    abstract public function postProcessNode(INode $node);
}
