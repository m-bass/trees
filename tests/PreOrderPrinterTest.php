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
use trees\PreOrderPrinter ;

class PreOrderPrinterTest extends \PHPUnit\Framework\TestCase
{
    protected $tree;
    protected $expectedOutput;
    protected $expectedExpression;

    protected function setUp()
    {
        $this->expectedExpression =
            "root first1 sec1 third1 sec2 third2 third3 first2 sec3 third4 sec4 third5 first3 " .
            "sec5 third6 third7 sec6 third8 third9 first4 sec7 third10 third11 sec8 third12 "
            ;

        $this->expectedOutput =
            "root". PHP_EOL  .
            "..first1" . PHP_EOL .
            "....sec1" . PHP_EOL .
            "......third1" . PHP_EOL .
            "....sec2" . PHP_EOL .
            "......third2" . PHP_EOL .
            "......third3" . PHP_EOL .
            "..first2" . PHP_EOL .
            "....sec3" . PHP_EOL .
            "......third4" . PHP_EOL .
            "....sec4" . PHP_EOL .
            "......third5" . PHP_EOL .
            "..first3" . PHP_EOL .
            "....sec5" . PHP_EOL .
            "......third6" . PHP_EOL .
            "......third7" . PHP_EOL .
            "....sec6" . PHP_EOL .
            "......third8" . PHP_EOL .
            "......third9" . PHP_EOL .
            "..first4" . PHP_EOL .
            "....sec7" . PHP_EOL .
            "......third10" . PHP_EOL .
            "......third11" . PHP_EOL .
            "....sec8" . PHP_EOL .
            "......third12" . PHP_EOL
            ;

        /*

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
          |    +--sec4
          |         +--third5
          +--first3
          |    +--sec5
          |    |    +--third6
          |    |    +--third7
          |    +--sec6
          |         +--third8
          |         +--third9
          +--first4
               +--sec7
               |    +--third10
               |    +--third11
               +--sec8
                    +--third12

         */
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
        $t = new TestNode('third7');
        $s->addChild($t);
        $s = new TestNode('sec6');
        $f->addChild($s);
        $t = new TestNode('third8');
        $s->addChild($t);
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

    public function testOutput()
    {
        $vis = new PreOrderPrinter();
        $vis->visit($this->tree);
        $dumpOutput = $vis->dumpTree();
        $this->assertEquals($this->expectedOutput, $dumpOutput);
    }

    public function testExpression()
    {
        $vis = new PreOrderPrinter();
        $vis->visit($this->tree);
        $expr = $vis->dumpExpression();
        $this->assertEquals($this->expectedExpression, $expr);
    }
}
