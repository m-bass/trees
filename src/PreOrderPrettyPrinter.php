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
 * Render contents of an INode in a tree-like format
 * like the Linux tree command.
 * The dumpExpression method is not implemented yet.
 */
class PreOrderPrettyPrinter extends PreOrderTraversal implements ITreeDumper
{
    use TreeDumper;

    /**
     * @var int
     */
    private $vertOffset;

    /**
     * @var int
     */
    private $horizOffset;

    /**
     * @var string
     */
    private $layout = '';

    /**
     * @param int $horizOffset
     * @param int $vertOffset
     */
    public function __construct($horizOffset = 2, $vertOffset = 0)
    {
        $this->horizOffset = $horizOffset;
        $this->vertOffset = $vertOffset;
    }

    public function processNode(INode $node)
    {
        $depth = $node->depth();

        // trim the layout
        $this->layout = substr($this->layout, 0, $this->horizOffset*($depth-1));

        // vertical offset
        $this->layout .= '|';
        if ($depth) {
            for ($i=0; $i<$this->vertOffset; $i++) {
                $this->setTree($this->getTree() . $this->layout . PHP_EOL);
            }
        }
        $this->layout = substr($this->layout, 0, -1);

        // node
        $this->setTree($this->getTree() . $this->layout);
        if ($depth) {
            if (isset($node->rightSibling)) {
                $this->setTree($this->getTree() . '├');
            } else {
                $this->setTree($this->getTree() . '└');
            }
            $this->setTree($this->getTree() . str_repeat('─', $this->horizOffset-1));
        }
        $this->setTree($this->getTree() . $node->getValue() . PHP_EOL);

        // put vert. bar
        if (isset($node->rightSibling)) {
            $this->layout .= '|';
        }

        // add white space
        $this->layout .= str_repeat(' ', $depth*$this->horizOffset) ;
    }
}
