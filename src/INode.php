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
 * Interface definition for a Node.
 * A Node is a prime example of the Composite Design Pattern that lets you
 * compose objects in tree structures to represent part-whole hierarchies.
 */
interface INode
{

    /**
     * Get the node's value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Set the node's value
     *
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * Insert the right sibling
     *
     * @param INode $node
     */
    public function insertRightSibling(INode $node);

    /**
     * Insert the left child
     *
     * @param INode $node
     */
    public function insertLeftChild(INode $node);

    /**
     * Add a child
     *
     * @param INode $node
     */
    public function addChild(INode $node);

    /**
     * Check if this tree contains a given node
     *
     * @param INode $node
     *
     * @return boolean
     */
    public function contains(INode $node);

    /**
     * Get the number of children
     *
     * @return int
     */
    public function numberOfChildren();

    /**
     * Get all children
     *
     * @return INode[]
     */
    public function children();

    /**
     * Get all siblings
     *
     * @return INode[]
     */
    public function siblings();

    /**
     * Removes this node
     */
    public function remove();

    /**
     * Get the depth of this node in the tree
     *
     * @return int
     */
    public function depth();

    /**
     * Check if this is a leaf (no children)
     *
     * @return boolean
     */
    public function isLeaf();

    /**
     * Check if this is the root of the the tree
     *
     * @return boolean
     */
    public function isRoot();

    /**
     * Get the root of this tree
     *
     * @return INode
     */
    public function getRoot();

    /**
     * Get this node's parent
     *
     * @return INode
     */
    public function getParent();

    /**
     * remove the node's parent
     */
    public function removeParent();

    /**
     * Set the node's parent
     *
     * @param INode $node
     */
    public function setParent(INode $node);

    /**
     * Get a deep clone of this tree structure.
     *
     * @return INode
     */
    public function getClone();

    /**
     * The Visitor design pattern, from the GoF
     *
     * @param INodeVisitor $visitor
     */
    public function accept(INodeVisitor $visitor);
}
