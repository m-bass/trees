<?php
/*
 * This file is part of trees.
 *
 * (c) Marco Bosatta
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace trees\tests;

use trees\tests\TestNode ;
use trees\PreOrderPrettyPrinter ;

class PreOrderPrettyPrinterTest extends \PHPUnit\Framework\TestCase
{
    protected $tree;
    protected $simpleTree;
    protected $expectedOutput;
    protected $expectedSimpleOutput;
    protected $expectedChildOutput;

    protected function setUp()
    {
        $this->expectedSimpleOutput =
            "root"                   . PHP_EOL .
            "|"                      . PHP_EOL .
            "|"                      . PHP_EOL .
            "└───first"              . PHP_EOL .
            "    |"                  . PHP_EOL .
            "    |"                  . PHP_EOL .
            "    └───sec"            . PHP_EOL .
            "        |"              . PHP_EOL .
            "        |"              . PHP_EOL .
            "        └───third"      . PHP_EOL .
            "            |"          . PHP_EOL .
            "            |"          . PHP_EOL .
            "            └───fourth" . PHP_EOL
            ;
        $this->expectedChildOutput =
            "first3"                     . PHP_EOL .
            "|"                          . PHP_EOL .
            "├──sec5"                    . PHP_EOL .
            "|  |"                       . PHP_EOL .
            "|  ├──third6"               . PHP_EOL .
            "|  |  |"                    . PHP_EOL .
            "|  |  └──fourth2"           . PHP_EOL .
            "|  |     |"                 . PHP_EOL .
            "|  |     ├──fifth1"         . PHP_EOL .
            "|  |     |  |"              . PHP_EOL .
            "|  |     |  ├──sixth1"      . PHP_EOL .
            "|  |     |  |"              . PHP_EOL .
            "|  |     |  └──sixth2"      . PHP_EOL .
            "|  |     |"                 . PHP_EOL .
            "|  |     └──fifth2"         . PHP_EOL .
            "|  |"                       . PHP_EOL .
            "|  └──third7"               . PHP_EOL .
            "|"                          . PHP_EOL .
            "└──sec6"                    . PHP_EOL .
            "   |"                       . PHP_EOL .
            "   ├──third8"               . PHP_EOL .
            "   |  |"                    . PHP_EOL .
            "   |  ├──fourth3"           . PHP_EOL .
            "   |  |"                    . PHP_EOL .
            "   |  └──fourth4"           . PHP_EOL .
            "   |"                       . PHP_EOL .
            "   └──third9"               . PHP_EOL
            ;
        $this->expectedOutput =
            "root"                    . PHP_EOL .
            "├─first1"                . PHP_EOL .
            "| ├─sec1"                . PHP_EOL .
            "| | └─third1"            . PHP_EOL .
            "| └─sec2"                . PHP_EOL .
            "|   ├─third2"            . PHP_EOL .
            "|   └─third3"            . PHP_EOL .
            "├─first2"                . PHP_EOL .
            "| ├─sec3"                . PHP_EOL .
            "| | └─third4"            . PHP_EOL .
            "| |   └─fourth1"         . PHP_EOL .
            "| └─sec4"                . PHP_EOL .
            "|   └─third5"            . PHP_EOL .
            "├─first3"                . PHP_EOL .
            "| ├─sec5"                . PHP_EOL .
            "| | ├─third6"            . PHP_EOL .
            "| | | └─fourth2"         . PHP_EOL .
            "| | |   ├─fifth1"        . PHP_EOL .
            "| | |   | ├─sixth1"      . PHP_EOL .
            "| | |   | └─sixth2"      . PHP_EOL .
            "| | |   └─fifth2"        . PHP_EOL .
            "| | └─third7"            . PHP_EOL .
            "| └─sec6"                . PHP_EOL .
            "|   ├─third8"            . PHP_EOL .
            "|   | ├─fourth3"         . PHP_EOL .
            "|   | └─fourth4"         . PHP_EOL .
            "|   └─third9"            . PHP_EOL .
            "└─first4"                . PHP_EOL .
            "  ├─sec7"                . PHP_EOL .
            "  | ├─third10"           . PHP_EOL .
            "  | └─third11"           . PHP_EOL .
            "  └─sec8"                . PHP_EOL .
            "    └─third12"           . PHP_EOL
            ;

        /*

        This is the simple test tree:
         root
          +--first
               +--sec
                   +--third
                       +--fourth

        This is the test tree:
          root
           +--first1
           |    +--sec1
           |    |    +--third1
           |    +--sec2
           |         +--third2
           |         +--third3
           +--first2
           |    +--sec3
           |    |    +--third4
           |    |        +--fourth1
           |    +--sec4
           |         +--third5
           +--first3
           |    +--sec5
           |    |    +--third6
           |    |    |   +--fourth2
           |    |    |       +--fifth1
           |    |    |       |   +--sixth1
           |    |    |       |   +--sixth2
           |    |    |       +--fifth2
           |    |    +--third7
           |    +--sec6
           |         +--third8
           |         |   +--fourth3
           |         |   +--fourth4
           |         +--third9
           +--first4
                +--sec7
                |    +--third10
                |    +--third11
                +--sec8
                     +--third12

         */
        $this->simpleTree = new TestNode('root');
        $f = new TestNode('first');
        $this->simpleTree->addChild($f);
        $s = new TestNode('sec');
        $f->addChild($s);
        $t = new TestNode('third');
        $s->addChild($t);
        $ff = new TestNode('fourth');
        $t->addChild($ff);

        $this->tree = new TestNode('root');
        $f = new TestNode('first1');
        $this->tree->addChild($f);
        $s = new TestNode('sec1');
        $f->addChild($s);
        $t = new TestNode('third1');
        $s->addChild($t);
        $s = new TestNode('sec2');
        $f->addChild($s);
        $t = new TestNode('third2');
        $s->addChild($t);
        $t = new TestNode('third3');
        $s->addChild($t);
        $f = new TestNode('first2');
        $this->tree->addChild($f);
        $s = new TestNode('sec3');
        $f->addChild($s);
        $t = new TestNode('third4');
        $s->addChild($t);
        $ff = new TestNode('fourth1');
        $t->addChild($ff);
        $s = new TestNode('sec4');
        $f->addChild($s);
        $t = new TestNode('third5');
        $s->addChild($t);
        $f = new TestNode('first3');
        $this->tree->addChild($f);
        $s = new TestNode('sec5');
        $f->addChild($s);
        $t = new TestNode('third6');
        $s->addChild($t);
        $ff = new TestNode('fourth2');
        $t->addChild($ff);
        $fff = new TestNode('fifth1');
        $ff->addChild($fff);
        $ss = new TestNode('sixth1');
        $fff->addChild($ss);
        $ss = new TestNode('sixth2');
        $fff->addChild($ss);
        $fff = new TestNode('fifth2');
        $ff->addChild($fff);
        $t = new TestNode('third7');
        $s->addChild($t);
        $s = new TestNode('sec6');
        $f->addChild($s);
        $t = new TestNode('third8');
        $s->addChild($t);
        $ff = new TestNode('fourth3');
        $t->addChild($ff);
        $ff = new TestNode('fourth4');
        $t->addChild($ff);
        $t = new TestNode('third9');
        $s->addChild($t);
        $f = new TestNode('first4');
        $this->tree->addChild($f);
        $s = new TestNode('sec7');
        $f->addChild($s);
        $t = new TestNode('third10');
        $s->addChild($t);
        $t = new TestNode('third11');
        $s->addChild($t);
        $s = new TestNode('sec8');
        $f->addChild($s);
        $t = new TestNode('third12');
        $s->addChild($t);
    }

    public function testSimpleOutput()
    {
        $dumpOutput = (new PreOrderPrettyPrinter($this->simpleTree, 4, 2))->dumpTree();
        $this->assertEquals($this->expectedSimpleOutput, $dumpOutput);
    }

    public function testOutput()
    {
        $dumpOutput = (new PreOrderPrettyPrinter($this->tree))->dumpTree();
        $this->assertEquals($this->expectedOutput, $dumpOutput);
    }

    public function testChildOutput()
    {
        // tree must be rooted for nice output
        $obj = $this->tree->leftChild->rightSibling->rightSibling;
        $obj->removeParent();
        $obj->rightSibling=null;
        $dumpOutput = (new PreOrderPrettyPrinter($obj, 3, 1))->dumpTree();
        $this->assertEquals($this->expectedChildOutput, $dumpOutput);
    }
}
