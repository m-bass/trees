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
use trees\PostOrderPrettyPrinter ;

class PostOrderPrettyPrinterTest extends \PHPUnit\Framework\TestCase
{
    protected $tree;
    protected $simpleTree;
    protected $expectedOutput;
    protected $expectedSimpleOutput;
    protected $expectedChildOutput;

    protected function setUp()
    {
        $this->expectedSimpleOutput =
            "            ┌───fourth" . PHP_EOL .
            "            |"          . PHP_EOL .
            "            |"          . PHP_EOL .
            "        ┌───third"      . PHP_EOL .
            "        |"              . PHP_EOL .
            "        |"              . PHP_EOL .
            "    ┌───sec"            . PHP_EOL .
            "    |"                  . PHP_EOL .
            "    |"                  . PHP_EOL .
            "┌───first"              . PHP_EOL .
            "|"                      . PHP_EOL .
            "|"                      . PHP_EOL .
            "root"                   . PHP_EOL
            ;
        $this->expectedChildOutput =
            "   ┌──third1" . PHP_EOL .
            "┌──sec1"      . PHP_EOL .
            "|  ┌──third2" . PHP_EOL .
            "|  ├──third3" . PHP_EOL .
            "├──sec2"      . PHP_EOL .
            "first1"       . PHP_EOL
            ;
        $this->expectedOutput =
            "    ┌─third1"       . PHP_EOL .
            "  ┌─sec1"           . PHP_EOL .
            "  | ┌─third2"       . PHP_EOL .
            "  | ├─third3"       . PHP_EOL .
            "  ├─sec2"           . PHP_EOL .
            "┌─first1"           . PHP_EOL .
            "|   ┌─third4"       . PHP_EOL .
            "|   |     ┌─sixth1" . PHP_EOL .
            "|   |   ┌─fifth1"   . PHP_EOL .
            "|   | ┌─fourth1"    . PHP_EOL .
            "|   ├─third5"       . PHP_EOL .
            "| ┌─sec3"           . PHP_EOL .
            "├─first2"           . PHP_EOL .
            "| ┌─sec4"           . PHP_EOL .
            "| | ┌─third6"       . PHP_EOL .
            "| | ├─third7"       . PHP_EOL .
            "| ├─sec5"           . PHP_EOL .
            "| | ┌─third8"       . PHP_EOL .
            "| | | ┌─fourth2"    . PHP_EOL .
            "| | ├─third9"       . PHP_EOL .
            "| ├─sec6"           . PHP_EOL .
            "├─first3"           . PHP_EOL .
            "root"               . PHP_EOL
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
          |         +--third4
          |         +--third5
          |              +--fourth1
          |                  +--fifth1
          |                      +--sixth1
          +--first3
               +--sec4
               +--sec5
               |    +--third6
               |    +--third7
               +--sec6
                    +--third8
                    +--third9
                         +--fourth2

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
        $t = new TestNode('third5');
        $s->addChild($t);
        $ff = new TestNode('fourth1');
        $t->addChild($ff);
        $fff = new TestNode('fifth1');
        $ff->addChild($fff);
        $ss = new TestNode('sixth1');
        $fff->addChild($ss);
        $f = new TestNode('first3');
        $this->tree->addChild($f);
        $s = new TestNode('sec4');
        $f->addChild($s);
        $s = new TestNode('sec5');
        $f->addChild($s);
        $t = new TestNode('third6');
        $s->addChild($t);
        $t = new TestNode('third7');
        $s->addChild($t);
        $s = new TestNode('sec6');
        $f->addChild($s);
        $t = new TestNode('third8');
        $s->addChild($t);
        $t = new TestNode('third9');
        $s->addChild($t);
        $ff = new TestNode('fourth2');
        $t->addChild($ff);
    }

    public function testSimpleOutput()
    {
        $dumpOutput = (new PostOrderPrettyPrinter($this->simpleTree, 4, 2))->dumpTree();
        $this->assertEquals($this->expectedSimpleOutput, $dumpOutput);
    }

    public function testOutput()
    {
        $dumpOutput = (new PostOrderPrettyPrinter($this->tree))->dumpTree();
        $this->assertEquals($this->expectedOutput, $dumpOutput);
    }

    public function testChildOutput()
    {
        // tree must be rooted for nice output
        $obj = $this->tree->leftChild;
        $obj->removeParent();
        $dumpOutput = (new PostOrderPrettyPrinter($obj, 3, 0))->dumpTree();
        $this->assertEquals($this->expectedChildOutput, $dumpOutput);
    }
}
