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
 * Interface for traversing a tree.
 * A concrete subclass has to implement the processNode method.
 */
interface ITreeTraversal extends INodeVisitor
{
    public function processNode(INode $node);
}
