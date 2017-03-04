<?php

namespace Commission\Tests;

use Commission\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    /**
     * @var Math
     */
    private $math;
    private $left;
    private $right;
    private $scale;

    public function setUp()
    {
        $this->math = new Math();
        $this->left = 9.123456789;
        $this->right = 2.987654321;
        $this->scale = 10;
    }

    public function testCalculateByPercentage()
    {
        $this->assertEquals('0.638', $this->math->calculateByPercentage($this->left, 7));
        $this->assertEquals('10', $this->math->calculateByPercentage($this->left, 7, 10));
        $this->assertEquals('0.5', $this->math->calculateByPercentage($this->left, 7, null, 0.5));

        $this->assertEquals('0.209', $this->math->calculateByPercentage($this->right, 7));
        $this->assertEquals('10', $this->math->calculateByPercentage($this->right, 7, 10));
        $this->assertEquals('0.1', $this->math->calculateByPercentage($this->right, 7, null, 0.1));
    }

    public function testDiv()
    {
        $this->assertEquals('3.053', $this->math->div($this->left, $this->right));
        $this->assertEquals('3.0537190078', $this->math->div($this->left, $this->right, $this->scale));
        $this->assertEquals('0.327', $this->math->div($this->right, $this->left));
        $this->assertEquals('0.3274695534', $this->math->div($this->right, $this->left, $this->scale));
    }

    public function testMul()
    {
        $this->assertEquals('27.257', $this->math->mul($this->left, $this->right));
        $this->assertEquals('27.2577350981', $this->math->mul($this->left, $this->right, $this->scale));
    }

    public function testFormatAndRound()
    {
        $this->assertEquals('9.13', $this->math->formatAndRound($this->left));
        $this->assertEquals('9.124', $this->math->formatAndRound($this->left, 3));
        $this->assertEquals('2.99', $this->math->formatAndRound($this->right));
        $this->assertEquals('2.988', $this->math->formatAndRound($this->right, 3));
    }

    public function testRoundUp()
    {
        $this->assertEquals('9.130', $this->math->roundUp($this->left));
        $this->assertEquals('9.123', $this->math->roundUp($this->left, 4));
        $this->assertEquals('2.990', $this->math->roundUp($this->right));
        $this->assertEquals('2.987', $this->math->roundUp($this->right, 4));
    }

    public function testPow()
    {
        $this->assertEquals('437960330.836', $this->math->pow($this->left, 9));
        $this->assertEquals('437960330.8369109117', $this->math->pow($this->left, 9, $this->scale));
    }

    public function testAdd()
    {
        $this->assertEquals('12.111', $this->math->add($this->left, $this->right));
        $this->assertEquals('12.1111111100', $this->math->add($this->left, $this->right, $this->scale));
    }

    public function testSub()
    {
        $this->assertEquals('6.135', $this->math->sub($this->left, $this->right));
        $this->assertEquals('6.1358024680', $this->math->sub($this->left, $this->right, $this->scale));
    }
}