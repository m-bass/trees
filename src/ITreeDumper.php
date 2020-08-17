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
 * Interface for dumping a tree.
 */
interface ITreeDumper
{
    public function dumpTree(INode $node);

    public function dumpExpression(INode $node);
}
