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
 * This class creates a deep clone (a full copy) of a tree.
 * It follows the Visitor design pattern.
 */
class DeepCloner extends PrePostOrderTraversal
{
    protected $deepClone = null ;

    // stack for storing parent node
    private $parent = array() ;

    /**
     * PHP's clone method is used
     * to clone each individual Node.
     */
    public function preProcessNode(INode $node)
    {
        $cloned = clone $node;
        // remove all references, because PHP's clone method does shallow copies
        $cloned->removeParent();
        $cloned->leftChild=null;
        $cloned->rightSibling=null;
        $cloned->leftChild=null;
        if (empty($this->parent)) {
            $this->deepClone = $cloned;
        } else {
            end($this->parent)->addChild($cloned);
        }

        array_push($this->parent, $cloned);
    }

    public function postProcessNode(INode $node)
    {
        array_pop($this->parent);
    }

    /**
     * Returns the deep clone.
     * @param INode
     * @return INode
     */
    public function getClone(INode $node)
    {
        $this->visit($node);
        return $this->deepClone ;
    }
}
