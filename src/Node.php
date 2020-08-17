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
 * Left-child right-sibling representation of Node class for rooted tree.
 * See "Introduction to algorithms", Cormen et al, The MIT Press p214,215
 * A Node is a typical Composite Design Pattern that allows you to compose
 * objects into tree structures to represent part-whole hierarchies.
 */
trait Node
{
    public $value;
    private $parent;
    public $leftChild;
    public $rightSibling;
    // pointer to last child, useful for function addChild
    protected $lastChild;

    public function __construct($value)
    {
        $this->setValue($value);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function insertRightSibling(INode $node)
    {
        if ($this->isRoot()) {
            throw new \LogicException("cannot add right sibling to root Node");
        }
        $this->rightSibling = $node;
        $node->setParent($this->parent);
        $this->parent->lastChild = $node;
    }

    public function insertLeftChild(INode $node)
    {
        if (!($this->isLeaf())) {
            throw new \LogicException("cannot add left child to non-leaf Node");
        }
        $this->leftChild = $node;
        $node->setParent($this);
        $this->lastChild = $node;
    }

    public function addChild(INode $child)
    {
        if ($this->isLeaf()) {
            $this->insertLeftChild($child);
        } else {
            $this->lastChild->insertRightSibling($child);
        }
    }

    public function contains($value)
    {
        return (new ValueSearcher($this))->search($value);
    }

    public function numberOfChildren()
    {
        return count($this->children());
    }

    public function children()
    {
        $children = array();
        if ($this->leftChild) {
            array_push($children, $this->leftChild);
            foreach ($this->leftChild->siblings() as $node) {
                array_push($children, $node);
            }
        }
        return $children;
    }

    public function siblings()
    {
        $siblings = array();
        $node = $this;
        while (null != ($node = $node->rightSibling)) {
            array_push($siblings, $node);
        }
        return $siblings;
    }

    public function remove()
    {
        if ($this->isRoot()) {
            // do nothing
        } else {
            $p = $this->parent;
            if ($p->leftChild!==$this) {
                $parentLeftChild = $p->leftChild;
                $s = $parentLeftChild->siblings();
                $i = 0;
                while ($this !== $parentLeftChild->rightSibling) {
                    $parentLeftChild = $s[$i++];
                }
                // point my right sibling to my left sibling
                $parentLeftChild->rightSibling = $this->rightSibling;
                // handle parent's last child
                if ($this===$p->lastChild) {
                    $p->lastChild = $parentLeftChild;
                }
            } else {
                // point my right sibling as new left child of parent
                $p->leftChild = $this->rightSibling;
                // handle parent's last child
                if ($this===$p->lastChild) {
                    $p->lastChild = null;
                }
            }
            // cleaning vars
            $this->parent = null;
            $this->rightSibling = null;
        }
    }

    public function depth()
    {
        $depth = 0;
        $node = $this;
        while (null !== $node->getParent()) {
            $node = $node->getParent();
            $depth++;
        }
        return $depth;
    }

    public function isLeaf()
    {
        return (!(isset($this->leftChild)));
    }

    public function isRoot()
    {
        return (!(isset($this->parent)));
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(INode $node)
    {
        $this->parent = $node;
    }

    public function removeParent()
    {
        $this->parent = null;
    }

    public function getRoot()
    {
        $node = $this;
        while (null !== $node->getParent()) {
            $node = $node->getParent();
        }
        return $node;
    }

    /**
     * Creates a deep clone of this Node,
     * without shallow references.
     */
    public function getClone()
    {
        $cloned = clone $this;
        // remove all references, they are not cloned by PHP's clone method
        $cloned->removeParent();
        $cloned->leftChild=null;
        $cloned->rightSibling=null;
        $cloned->leftChild=null;

        foreach ($this->children() as $child) {
            $node = $child->getClone();
            $cloned->addChild($node);
        }
        return $cloned;
    }

    public function accept(INodeVisitor $visitor)
    {
        $visitor->visit($this);
    }
}
