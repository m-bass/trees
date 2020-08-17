# trees

Just another implementation of object trees, with flexible traversal and dumping utilities

## Overview

Object hierarchies and trees are almost ubiquitous in IT.
It's amazing that most standard libraries (and SPL is no exception) do not provide an implementation for it.
That was reason enough for me to write a library for creating, traversing, and printing trees.

## The data structure

The `trees\INode` interface defines the concept of a tree's node.
A **Node** is a prime example of the **Composite Design Pattern** that lets you
compose objects in tree structures to represent part-whole hierarchies.
The `trees\Node` trait is a straightforward implementation following the 
left-child right-sibling representation for rooted trees, as described by
*(Cormen, Leiserson & Rivest), Introduction to algorithms (New York: The MIT Press, 1999), 213–215.*
Any tree is internally represented by a binary tree, but this stays transparent to you as developer.

## Create a tree of custom classes

You can make up an object tree with any of your PHP classes.
Just implement the `trees\INode` interface and use the `trees\Node` trait.

```php
use trees\Node ;
use trees\INode ;

class MyClass implements INode
{
    use Node;

    /**
     * Add your custom implementation here
     * ...
     */

}
```

### An example

```php
$root = new MyClass('root');

$root->addChild($A = new MyClass('A'));
$root->addChild($B = new MyClass('B'));
$root->addChild($C = new MyClass('C'));

$B->addChild(new MyClass('D'));
$B->addChild(new MyClass('E'));
$C->addChild(new MyClass('F'));
```
yields the following tree of MyClass instances:
```
        root
       /  |  \
      A   B   C
         / \   \ 
        D   E   F
```

## Tree traversal 

Perhaps the most interesting part of this small framework are the traversal utilities. 
<p>
Different traversal skeletons are provided, which depending on the traversal order, have 
to implement the processNode method.

### Pre-order

For example, a pre-order traversal is defined as 
1. Process the current node
2. Traverse the current node's children recursively from left to right.d
The PreOrderTraversal abstract class provides this behaviour using the Visitor pattern,
but it is left to you how you want to process the current node.

### In-order

Provides a partial implementation for in-order traversal on a tree.
A in-order traversal on a tree performs the following steps:
1. Traverse the current node's left child recursively
2. Process the current node
3. Traverse the current node's right children recursively

```php
class MyPreOrderTraveler extends PreOrderTraversal
{

    /**
     * Define here how to process the current node
     * during pre-order traversal.
     */
    public function processNode(INode $node)
    {
        // a simple example
        echo($node->getValue() . ' ');
    }

}

(new MyPreOrderTraveler())->visit($root);
```

The last line yields the following result:
```
    root A B D E C F
```



### Post-order

Provides a partial implementation for post-order traversal on a tree.
A post-order traversal on a tree performs the following steps:
1. Traverse the current node's children recursively from left to right.
2. Process the current node

## Tree dumping

## Tests

Run the unit test suite
```
phpunit 
```
