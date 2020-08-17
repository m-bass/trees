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
use trees\DeepCloner ;

class DeepClonerTest extends \PHPUnit\Framework\TestCase
{
    protected $tree;

    protected function setUp()
    {
        /*

        This is the test tree:
         root
          +--first1
          |    +--sec1
          |    |    +--third1
          |    |    +--third2
          |    +--sec2
          |    +--sec3
          |         +--third3
          +--first2
          |    +--sec4
          |         +--third4
          |         +--third5
          +--first3
          +--first4
          |    +--sec5
          |    +--sec6
          |    |    +--third6
          |    |    +--third7
          |    |    +--third8
          |    +--sec7
          |    |    +--third9
          |    +--sec8
          +--first5
               +--sec9

         */
        $this->tree = new TestNode('root');
        $this->tree->addChild($first1 = new TestNode('first1'));
        $first1->addChild($sec1 = new TestNode('sec1'));
        $sec1->addChild(new TestNode('third1'));
        $sec1->addChild(new TestNode('third2'));
        $first1->addChild($sec2 = new TestNode('sec2'));
        $first1->addChild($sec3 = new TestNode('sec3'));
        $sec3->addChild(new TestNode('third3'));
        $this->tree->addChild($first2 = new TestNode('first2'));
        $first2->addChild($sec4 = new TestNode('sec4'));
        $sec4->addChild(new TestNode('third4'));
        $sec4->addChild(new TestNode('third5'));
        $this->tree->addChild($first3 = new TestNode('first3'));
        $this->tree->addChild($first4 = new TestNode('first4'));
        $first4->addChild($sec5 = new TestNode('sec5'));
        $first4->addChild($sec6 = new TestNode('sec6'));
        $sec6->addChild(new TestNode('third6'));
        $sec6->addChild(new TestNode('third7'));
        $sec6->addChild(new TestNode('third8'));
        $first4->addChild($sec7 = new TestNode('sec7'));
        $sec7->addChild(new TestNode('third9'));
        $first4->addChild($sec8 = new TestNode('sec8'));
        $this->tree->addChild($first5 = new TestNode('first5'));
        $first5->addChild($sec9 = new TestNode('sec9'));
    }

    public function testCloning1()
    {
        // clone the whole tree
        $clone = (new DeepCloner())->getClone($this->tree);
        // run tests
        $this->assertEquals($clone, $this->tree);
        $this->assertNotSame($clone, $this->tree);
        $this->assertEquals($clone->children(), $this->tree->children());
        $this->assertNotSame($clone->children(), $this->tree->children());
    }

    public function testCloning2()
    {
        // make 2 clones of the second child
        $obj = $this->tree->leftChild->rightSibling;
        $obj->removeParent();
        $obj->rightSibling=null;
        $clone1 = (new DeepCloner())->getClone($obj);
        $clone2 = (new DeepCloner())->getClone($obj);
        // run some tests
        $this->assertEquals($clone1, $clone2);
        $this->assertNotSame($clone1, $clone2);
        $this->assertEquals($clone1, $obj);
        $this->assertNotSame($clone1, $obj);
        $this->assertEquals($clone2, $obj);
        $this->assertNotSame($clone2, $obj);
        $this->assertEquals($clone1->leftChild, $clone2->leftChild);
        $this->assertNotSame($clone1->leftChild, $clone2->leftChild);
        $this->assertEquals($clone1->leftChild, $obj->leftChild);
        $this->assertNotSame($clone1->leftChild, $obj->leftChild);
        $this->assertEquals($clone2->leftChild, $obj->leftChild);
        $this->assertNotSame($clone2->leftChild, $obj->leftChild);
        $this->assertEquals($clone1->children(), $clone2->children());
        $this->assertNotSame($clone1->children(), $clone2->children());
        $this->assertEquals($clone1->children(), $obj->children());
        $this->assertNotSame($clone1->children(), $obj->children());
        $this->assertEquals($clone2->children(), $obj->children());
        $this->assertNotSame($clone2->children(), $obj->children());
        $this->assertEquals($clone1->leftChild->leftChild, $clone2->leftChild->leftChild);
        $this->assertEquals($clone1->leftChild->leftChild, $obj->leftChild->leftChild);
        $this->assertEquals($clone2->leftChild->leftChild, $obj->leftChild->leftChild);
    }

    public function testCloning3()
    {
        // clone the 4th child
        $obj = $this->tree->leftChild->rightSibling->rightSibling->rightSibling;
        $obj->removeParent();
        $obj->rightSibling=null;
        $clone = (new DeepCloner())->getClone($obj);
        // run some tests
        $this->assertEquals($obj, $clone);
        $this->assertNotSame($obj, $clone);
        $this->assertEquals($obj->numberOfChildren(), $clone->numberOfChildren());
        $this->assertEquals($obj->leftChild, $clone->leftChild);
        $this->assertNotSame($obj->leftChild, $clone->leftChild);
        $this->assertEquals($obj->leftChild->rightSibling, $clone->leftChild->rightSibling);
        $this->assertNotSame($obj->leftChild->rightSibling, $clone->leftChild->rightSibling);
        $this->assertEquals(
            $obj->leftChild->rightSibling->rightSibling,
            $clone->leftChild->rightSibling->rightSibling
        );
        $this->assertNotSame(
            $obj->leftChild->rightSibling->rightSibling,
            $clone->leftChild->rightSibling->rightSibling
        );
        $this->assertEquals($obj->leftChild->rightSibling->leftChild, $clone->leftChild->rightSibling->leftChild);
        $this->assertNotSame($obj->leftChild->rightSibling->leftChild, $clone->leftChild->rightSibling->leftChild);
    }
}
