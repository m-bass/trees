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
 * Interface for the tree's Visitor.
 *      See https://en.wikipedia.org/wiki/Visitor_pattern:
 *      The Visitor design pattern is one of the GoF design patterns ...
 *      What problems can the Visitor design pattern solve?
 *      It should be possible to define a NEW OPERATION for (some) classes
 *      of an object structure WITHOUT CHANGING the classes.
 */
interface INodeVisitor
{
    public function visit(INode $node);
}
