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

class NodeTest extends \PHPUnit\Framework\TestCase
{
    protected $stmt;
    protected $IF;
    protected $ELSE;
    protected $THEN;
    protected $b;
    protected $div;
    protected $x2;
    protected $a;
    protected $equal1;

    protected function setUp()
    {
        /*

        This is the test tree:
         stmt
          +--IF
          |   +--=
          |      +--+
          |      |  +--a
          |      |  +--b
          |      |
          |      +--c
          +--THEN
          |   +--=
          |      +--x
          |      |
          |      +--*
          |         +--d
          |         +--e
          +--ELSE
              +--=
                 +--x
                 |
                 +--:
                    +--d
                    +--e

         */

        $this->stmt = new TestNode('stmt') ;
        $this->IF = new TestNode('IF') ;
        $this->equal1 = new TestNode('=') ;
        $plus = new TestNode('+') ;
        $this->a = new TestNode('a') ;
        $this->b = new TestNode('b') ;
        $c = new TestNode('c') ;
        $this->THEN = new TestNode('THEN') ;
        $equal2 = new TestNode('=') ;
        $x1 = new TestNode('x') ;
        $mult = new TestNode('*') ;
        $d1 = new TestNode('d') ;
        $e1 = new TestNode('e') ;
        $this->ELSE = new TestNode('ELSE') ;
        $equal3 = new TestNode('=') ;
        $this->x2 = new TestNode('x') ;
        $this->div = new TestNode(':') ;
        $d2 = new TestNode('d') ;
        $e2 = new TestNode('e') ;

        $this->stmt->addChild($this->IF);
        $this->stmt->addChild($this->THEN);
        $this->stmt->addChild($this->ELSE);
        $this->IF->addChild($this->equal1);
        $this->THEN->addChild($equal2);
        $this->ELSE->addChild($equal3);
        $this->equal1->addChild($plus);
        $this->equal1->addChild($c);
        $equal2->addChild($x1);
        $equal2->addChild($mult);
        $equal3->addChild($this->x2);
        $equal3->addChild($this->div);
        $plus->addChild($this->a);
        $plus->addChild($this->b);
        $mult->addChild($d1);
        $mult->addChild($e1);
        $this->div->addChild($d2);
        $this->div->addChild($e2);
    }

    public function testClassProperties()
    {
        $this->assertEquals($this->stmt, $this->ELSE->getParent());
        $this->assertEquals($this->stmt, $this->IF->getParent());
        $this->assertEquals($this->stmt, $this->THEN->getParent());
        $this->assertEquals($this->IF, $this->equal1->getParent());
        $this->assertEquals($this->IF, $this->stmt->leftChild);
        $this->assertEquals($this->THEN, $this->IF->rightSibling);
        $this->assertEquals($this->ELSE, $this->THEN->rightSibling);
        $this->assertEquals($this->b, $this->a->rightSibling);
        $this->assertEquals($this->div, $this->x2->rightSibling);
        $this->assertEquals('stmt', $this->stmt->getValue());
        $this->assertEquals('IF', $this->IF->getValue());
        $this->assertEquals('THEN', $this->THEN->getValue());
        $this->assertEquals('ELSE', $this->ELSE->getValue());
    }

    public function testInsertRightSibling()
    {
        $test = new TestNode('junk');
        $this->ELSE->insertRightSibling($test);
        $this->assertSame($test, $this->ELSE->rightSibling);
        $this->b->insertRightSibling($test);
        $this->assertSame($test, $this->b->rightSibling);
        $this->div->insertRightSibling($test);
        $this->assertSame($test, $this->div->rightSibling);
        $this->equal1->insertRightSibling($test);
        $this->assertSame($test, $this->equal1->rightSibling);
    }

    public function testInsertRightSiblingException()
    {
        $this->expectException(\LogicException::class);
        $this->stmt->insertRightSibling(new TestNode('junk'));
    }

    public function testInsertLeftChild()
    {
        $test = new TestNode('junk');
        $this->a->insertLeftChild($test);
        $this->assertSame($test, $this->a->leftChild);
        $this->x2->insertLeftChild($test);
        $this->assertSame($test, $this->x2->leftChild);
        $this->b->insertLeftChild($test);
        $this->assertSame($test, $this->b->leftChild);
    }

    public function testInsertLeftChildException1()
    {
        $this->expectException(\LogicException::class);
        $this->stmt->insertLeftChild(new TestNode('junk'));
    }

    public function testInsertLeftChildException2()
    {
        $this->expectException(\LogicException::class);
        $this->IF->insertLeftChild(new TestNode('junk'));
    }

    public function testInsertLeftChildException3()
    {
        $this->expectException(\LogicException::class);
        $this->THEN->insertLeftChild(new TestNode('junk'));
    }

    public function testInsertLeftChildException4()
    {
        $this->expectException(\LogicException::class);
        $this->ELSE->insertLeftChild(new TestNode('junk'));
    }

    public function testAddChild1()
    {
        $this->ELSE->remove();
        $this->IF->remove();
        $this->THEN->remove();
        $this->assertTrue($this->stmt->isLeaf());
        $this->assertTrue($this->stmt->isRoot());
        $this->assertTrue($this->ELSE->isRoot());
        $this->assertTrue($this->IF->isRoot());
        $this->assertTrue($this->THEN->isRoot());
        $this->stmt->addChild($this->ELSE);
        $this->stmt->addChild($this->IF);
        $this->stmt->addChild($this->THEN);
        $this->assertFalse($this->stmt->isLeaf());
        $this->assertTrue($this->stmt->isRoot());
        $this->assertEquals($this->stmt, $this->THEN->getParent());
        $this->assertEquals($this->stmt, $this->ELSE->getParent());
        $this->assertEquals($this->stmt, $this->IF->getParent());
        $this->assertEquals(null, $this->THEN->rightSibling);
        $this->assertEquals($this->IF, $this->ELSE->rightSibling);
        $this->assertEquals($this->THEN, $this->IF->rightSibling);
        $this->assertEquals($this->ELSE, $this->stmt->leftChild);
        $this->assertTrue($this->stmt->contains("IF"));
        $this->assertTrue($this->stmt->contains("a"));
        $this->assertTrue($this->stmt->contains(":"));
        $this->assertTrue($this->stmt->contains("ELSE"));
        $this->assertFalse($this->IF->isRoot());
        $this->assertFalse($this->ELSE->isRoot());
        $this->assertCount(3, $this->stmt->children());
    }

    public function testAddChild2()
    {
        $test = [];
        for ($i=1; $i<=23; $i++) {
            $test[$i] = new TestNode('add'.$i);
        }
        foreach ($test as $el) {
            $this->THEN->addChild($el);
        }
        foreach ($test as $el) {
            $this->assertTrue($this->THEN->contains($el->getValue()));
            $this->assertFalse($this->ELSE->contains($el->getValue()));
        }
    }

    public function testContains()
    {
        $this->assertTrue($this->stmt->contains($this->stmt->getValue()));
        $this->assertTrue($this->stmt->contains($this->IF->getValue()));
        $this->assertTrue($this->stmt->contains($this->THEN->getValue()));
        $this->assertTrue($this->stmt->contains($this->ELSE->getValue()));
        $this->assertTrue($this->stmt->contains($this->a->getValue()));
        $this->assertTrue($this->stmt->contains($this->b->getValue()));
        $this->assertTrue($this->stmt->contains($this->x2->getValue()));
        $this->assertTrue($this->stmt->contains($this->div->getValue()));
        $this->assertTrue($this->stmt->contains($this->equal1->getValue()));
        $this->assertTrue($this->IF->contains($this->a->getValue()));
        $this->assertTrue($this->IF->contains($this->b->getValue()));
        $this->assertFalse($this->IF->contains($this->div->getValue()));
        $this->assertFalse($this->IF->contains($this->x2->getValue()));
        $this->assertTrue($this->IF->contains($this->equal1->getValue()));
        $this->assertFalse($this->THEN->contains($this->div->getValue()));
        $this->assertFalse($this->THEN->contains("y"));
        $this->assertFalse($this->ELSE->contains($this->a->getValue()));
        $this->assertTrue($this->ELSE->contains($this->div->getValue()));
        $this->assertTrue($this->equal1->contains($this->a->getValue()));
        $this->assertTrue($this->a->contains($this->a->getValue()));
        $this->assertFalse($this->div->contains($this->stmt->getValue()));
    }

    public function testNumberOfChildren()
    {
        $this->assertEquals(3, $this->stmt->numberOfChildren());
        $this->assertEquals(1, $this->THEN->numberOfChildren());
        $this->assertEquals(1, $this->ELSE->numberOfChildren());
        $this->assertEquals(2, $this->div->numberOfChildren());
        $this->assertEquals(0, $this->a->numberOfChildren());
        $this->assertEquals(0, $this->b->numberOfChildren());
        $this->assertEquals(0, $this->x2->numberOfChildren());
    }

    public function testChildren()
    {
        $this->assertEquals(array(), $this->b->children());
        $this->assertEquals(array($this->IF,$this->THEN,$this->ELSE), $this->stmt->children());
        $this->assertEquals(array($this->equal1), $this->IF->children());
        $this->assertEquals(array(), $this->x2->children());
        $this->assertCount(2, $this->div->children());
        $this->assertCount(0, $this->a->children());
        $this->assertCount(0, $this->b->children());
    }

    public function testSiblings()
    {
        $this->assertEquals(array(), $this->stmt->siblings());
        $this->assertEquals(array($this->THEN,$this->ELSE), $this->IF->siblings());
        $this->assertEquals(array($this->b), $this->a->siblings());
        $this->assertEquals(array($this->div), $this->x2->siblings());
        $this->assertEquals(array(), $this->equal1->siblings());
    }

    public function testRemove1()
    {
        $this->IF->remove();
        $this->assertFalse($this->stmt->contains($this->IF->getValue()));
        $this->assertTrue($this->stmt->isRoot());
        $this->assertFalse($this->stmt->isLeaf());
        $this->assertEquals($this->THEN, $this->stmt->leftChild);
        $this->assertEquals($this->ELSE, $this->THEN->rightSibling);
        $this->assertEquals($this->stmt, $this->THEN->getParent());
        $this->assertEquals($this->stmt, $this->ELSE->getParent());
        $this->assertCount(2, $this->stmt->children());
        $this->assertEquals(array($this->THEN,$this->ELSE), $this->stmt->children());
        $this->assertTrue($this->IF->isRoot());
        $this->assertEquals(null, $this->IF->getParent());
        $this->assertEquals($this->equal1, $this->IF->leftChild);
        $this->assertEquals($this->IF, $this->equal1->getParent());
        $this->assertEquals(null, $this->IF->rightSibling);
    }

    public function testRemove2()
    {
        $this->ELSE->remove();
        $this->assertFalse($this->stmt->contains($this->ELSE->getValue()));
        $this->assertEquals($this->IF, $this->stmt->leftChild);
        $this->assertEquals($this->THEN, $this->IF->rightSibling);
        $this->assertEquals($this->stmt, $this->IF->getParent());
        $this->assertEquals($this->stmt, $this->THEN->getParent());
        $this->assertCount(2, $this->stmt->children());
        $this->assertEquals(array($this->IF,$this->THEN), $this->stmt->children());
        $this->assertTrue($this->ELSE->isRoot());
        $this->assertEquals(null, $this->ELSE->getParent());
        $this->assertTrue($this->ELSE->contains($this->x2->getValue()));
        $this->assertTrue($this->ELSE->contains($this->div->getValue()));
    }

    public function testDepth()
    {
        $this->assertEquals(0, $this->stmt->depth());
        $this->assertEquals(1, $this->IF->depth());
        $this->assertEquals(1, $this->THEN->depth());
        $this->assertEquals(1, $this->ELSE->depth());
        $this->assertEquals(2, $this->IF->leftChild->depth());
        $this->assertEquals(2, $this->equal1->depth());
        $this->assertEquals(3, $this->x2->depth());
        $this->assertEquals(3, $this->div->depth());
        $this->assertEquals(4, $this->a->depth());
        $this->assertEquals(4, $this->b->depth());
    }

    public function testIsLeaf()
    {
        $this->assertFalse($this->stmt->isLeaf());
        $this->assertFalse($this->div->isLeaf());
        $this->assertFalse($this->IF->isLeaf());
        $this->assertFalse($this->equal1->isLeaf());
        $this->assertTrue($this->a->isLeaf());
        $this->assertTrue($this->b->isLeaf());
        $this->assertTrue($this->x2->isLeaf());
        $this->assertTrue($this->div->leftChild->isLeaf());
        $this->assertTrue($this->div->leftChild->rightSibling->isLeaf());
    }

    public function testIsRoot()
    {
        $this->assertTrue($this->stmt->isRoot());
        $this->assertFalse($this->b->isRoot());
        $this->assertFalse($this->IF->isRoot());
        $this->assertFalse($this->THEN->isRoot());
        $this->assertFalse($this->x2->isRoot());
        $this->assertFalse($this->a->isRoot());
    }

    public function testGetRoot()
    {
        $this->assertEquals('stmt', $this->stmt->getRoot()->getValue());
        $this->assertEquals('stmt', $this->b->getRoot()->getValue());
        $this->assertEquals('stmt', $this->div->getRoot()->getValue());
        $this->assertEquals($this->stmt, $this->stmt->getRoot());
        $this->assertEquals($this->stmt, $this->IF->getRoot());
        $this->assertEquals($this->stmt, $this->THEN->getRoot());
        $this->assertEquals($this->stmt, $this->ELSE->getRoot());
        $this->assertEquals($this->stmt, $this->a->getRoot());
        $this->assertEquals($this->stmt, $this->b->getRoot());
        $this->assertEquals($this->stmt, $this->div->getRoot());
        $this->assertEquals($this->stmt, $this->equal1->leftChild->getRoot());
        $this->assertEquals($this->stmt, $this->div->leftChild->rightSibling->getRoot());
    }

    public function testCloning()
    {
        $cloneStmt = $this->stmt->getClone();
        // run tests
        $this->assertEquals($cloneStmt, $this->stmt);
        $this->assertNotSame($cloneStmt, $this->stmt);
        $this->assertEquals($cloneStmt->children(), $this->stmt->children());
        $this->assertNotSame($cloneStmt->children(), $this->stmt->children());
        // clones are rooted:
        $this->THEN->removeParent();
        $this->THEN->rightSibling=null;
        $clone1THEN = $this->THEN->getClone();
        $clone2THEN = $clone1THEN->getClone();
        // run tests
        $this->assertEquals($clone1THEN, $clone2THEN);
        $this->assertNotSame($clone1THEN, $clone2THEN);
        $this->assertEquals($clone1THEN, $this->THEN);
        $this->assertNotSame($clone1THEN, $this->THEN);
        $this->assertEquals($clone2THEN, $this->THEN);
        $this->assertNotSame($clone2THEN, $this->THEN);
        $this->assertEquals($clone1THEN->leftChild, $clone2THEN->leftChild);
        $this->assertNotSame($clone1THEN->leftChild, $clone2THEN->leftChild);
        $this->assertEquals($clone1THEN->leftChild, $this->THEN->leftChild);
        $this->assertNotSame($clone1THEN->leftChild, $this->THEN->leftChild);
        $this->assertEquals($clone2THEN->leftChild, $this->THEN->leftChild);
        $this->assertNotSame($clone2THEN->leftChild, $this->THEN->leftChild);
        $this->assertEquals($clone1THEN->children(), $clone2THEN->children());
        $this->assertNotSame($clone1THEN->children(), $clone2THEN->children());
        $this->assertEquals($clone1THEN->children(), $this->THEN->children());
        $this->assertNotSame($clone1THEN->children(), $this->THEN->children());
        $this->assertEquals($clone2THEN->children(), $this->THEN->children());
        $this->assertNotSame($clone2THEN->children(), $this->THEN->children());
        $this->assertEquals($clone1THEN->leftChild->leftChild, $clone2THEN->leftChild->leftChild);
        $this->assertEquals($clone1THEN->leftChild->leftChild, $this->THEN->leftChild->leftChild);
        $this->assertEquals($clone2THEN->leftChild->leftChild, $this->THEN->leftChild->leftChild);
        // clones are rooted:
        $this->ELSE->removeParent();
        $cloneELSE = $this->ELSE->getClone();
        // run tests
        $this->assertEquals($cloneELSE, $this->ELSE);
        $this->assertNotSame($cloneELSE, $this->ELSE);
        $this->assertEquals($cloneELSE->leftChild, $this->ELSE->leftChild);
        $this->assertNotSame($clone1THEN->leftChild, $this->ELSE->leftChild);
        $this->assertEquals($cloneELSE->leftChild->leftChild, $this->ELSE->leftChild->leftChild);
    }
}
