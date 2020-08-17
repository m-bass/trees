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
 * Inverse "tree"-like renderer for an INode.
 * The dumpExpression method is not implemented yet.
 */
class PostOrderPrettyPrinter extends PostOrderTraversal implements ITreeDumper
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

    public function processNode(INode $node)
    {
        // DISPLAY
        $d = $node->depth();

        // add white space
        $this->layout .= str_repeat(' ', $d*$this->horizOffset) ;
        // trim
        $this->layout = substr($this->layout, 0, $this->horizOffset*($d-1));

        // node
        $this->setTree($this->getTree() . $this->layout);
        if ($d) {
            if ($node->getParent()->leftChild===$node) {
                $this->setTree($this->getTree() . '┌');
            } else {
                $this->setTree($this->getTree() . '├');
            }
            $this->setTree($this->getTree() . str_repeat('─', $this->horizOffset-1));
        }
        $this->setTree($this->getTree() . $node->getValue() . PHP_EOL);

        // vertical offset
        $this->layout .= '|';
        if ($d) {
            for ($i=0; $i<$this->vertOffset; $i++) {
                $this->setTree($this->getTree() . $this->layout . PHP_EOL);
            }
        }
    }


    /**
      * @param int $horizOffset
      * @param int $vertOffset
      */
    public function __construct($horizOffset = 2, $vertOffset = 0)
    {
        $this->horizOffset = $horizOffset;
        $this->vertOffset = $vertOffset;
    }
}
