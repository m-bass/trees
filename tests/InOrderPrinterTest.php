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
use trees\InOrderPrinter ;

class InOrderPrinterTest extends \PHPUnit\Framework\TestCase
{
    protected $tree;
    protected $expectedOutput;
    protected $expectedExpression;

    protected function setUp()
    {
        $this->expectedExpression =
            "11 * 2 - 6 : 3 "
            ;

        $this->expectedOutput =
            "....11" . PHP_EOL .
            "..*" . PHP_EOL .
            "....2" . PHP_EOL .
            "-". PHP_EOL  .
            "....6" . PHP_EOL .
            "..:" . PHP_EOL .
            "....3" . PHP_EOL
            ;

        /*

        This is the test tree:
          -
          +--*
          |  +--11
          |  +--2
          +--:
             +--6
             +--3

         */
        $this->tree = new TestNode('-');
        $f = new TestNode('*');
        $this->tree->addChild($f);
        $s = new TestNode('11');
        $f->addChild($s);
        $s = new TestNode('2');
        $f->addChild($s);
        $f = new TestNode(':');
        $this->tree->addChild($f);
        $s = new TestNode('6');
        $f->addChild($s);
        $s = new TestNode('3');
        $f->addChild($s);
    }

    public function testOutput()
    {
        $vis = new InOrderPrinter();
        $vis->visit($this->tree);
        $dumpOutput = $vis->dumpTree();
        $this->assertEquals($this->expectedOutput, $dumpOutput);
    }

    public function testExpression()
    {
        $vis = new InOrderPrinter();
        $vis->visit($this->tree);
        $expr = $vis->dumpExpression();
        $this->assertEquals($this->expectedExpression, $expr);
    }
}
