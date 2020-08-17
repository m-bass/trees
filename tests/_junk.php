<?php

namespace trees\tests;

require dirname(__FILE__) . '/../vendor/autoload.php';

use trees\Node ;
use trees\INode ;
use trees\INodeVisitor ;
use trees\PreOrderPrinter;
use trees\InOrderPrinter;
use trees\PostOrderPrinter;
use trees\PreOrderPrettyPrinter;
use trees\PostOrderPrettyPrinter;

class Car implements INode
{
    use Node;

    private $description;

    public function __construct($manufacturer, $speed, $year)
    {
        $this->description = [
            "manufacturer" => $manufacturer,
            "speed" => $speed,
            "year" => $year
        ];
        $this->setValue($this->description);
    }

    public function getValue()
    {
        $s = '££ ';
        foreach ($this->description as $key => $value) {
            $s .= $key . ':' . $value . ' ';
        }
        return $s . '££';
    }
}

$alfa = new Car('Alfa Romeo', 200, 1977);
$alfa->addChild($bmw = new Car('BMW', 220, 2001));
$alfa->addChild($fiat = new Car('Fiat', 165, 1998));
$fiat->addChild($Toyota = new Car('Toyota', 199, 2011));
$Toyota->addChild($Renault = new Car('Renault', 220, 2011));
$fiat->addChild($Nissan = new Car('Nissan', 150, 2008));
$alfa->addChild($audi = new Car('Audi A4', 230, 2010));
$audi->addChild($VW = new Car('VW Lupo', 250, 2018));



class MyClass implements INode
{
    use Node;

    /**
     * Add your custom implementation here
     * ...
     */
}

$root = new MyClass('root');

$root->addChild($A = new MyClass('A'));
$root->addChild($B = new MyClass('B'));
$root->addChild($C = new MyClass('C'));

$B->addChild(new MyClass('D'));
$B->addChild(new MyClass('E'));
$C->addChild(new MyClass('F'));


/**
 *  tests here
 */
echo PHP_EOL;
echo (new PreOrderPrinter())->dumpExpression($root);
echo PHP_EOL;
echo (new PreOrderPrinter())->dumpTree($root);
echo PHP_EOL;
echo (new PreOrderPrinter())->dumpExpression($alfa);
echo PHP_EOL;
echo (new PreOrderPrinter())->dumpTree($alfa);

echo PHP_EOL;
echo "IN order:";
echo PHP_EOL;
echo (new InOrderPrinter())->dumpExpression($root);
echo PHP_EOL;
echo (new InOrderPrinter())->dumpTree($root);
echo PHP_EOL;
echo (new InOrderPrinter())->dumpExpression($alfa);
echo PHP_EOL;
echo (new InOrderPrinter())->dumpTree($alfa);
echo PHP_EOL;
echo "IN order:";

echo PHP_EOL;
echo (new PostOrderPrinter())->dumpExpression($root);
echo PHP_EOL;
echo (new PostOrderPrinter())->dumpTree($root);
echo PHP_EOL;
echo (new PostOrderPrinter())->dumpExpression($alfa);
echo PHP_EOL;
echo (new PostOrderPrinter())->dumpTree($alfa);

echo PHP_EOL;
echo (new PreOrderPrettyPrinter())->dumpExpression($root);
echo PHP_EOL;
echo (new PreOrderPrettyPrinter(6, 2))->dumpTree($root);
echo PHP_EOL;
echo (new PreOrderPrettyPrinter(2, 2))->dumpExpression($alfa);
echo PHP_EOL;
echo (new PreOrderPrettyPrinter(10, 3))->dumpTree($alfa);

echo PHP_EOL;
echo (new PostOrderPrettyPrinter(3, 3))->dumpExpression($root);
echo PHP_EOL;
echo (new PostOrderPrettyPrinter(1, 2))->dumpTree($root);
echo PHP_EOL;
echo (new PostOrderPrettyPrinter(2, 2))->dumpExpression($alfa);
echo PHP_EOL;
echo (new PostOrderPrettyPrinter(7, 4))->dumpTree($alfa);
