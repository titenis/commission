<?php

namespace Commission\Tests;

use Commission\Entity\Money;
use Commission\Exception\CurrencyNotFoundException;
use Commission\Exception\InvalidAmountException;
use Commission\Exception\InvalidCurrencyException;
use Commission\Math;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @var Money
     */
    private $money;

    public function setUp()
    {
        $this->money = new Money(new Math());
    }

    public function testInvalidAmount()
    {
        $this->expectException(InvalidAmountException::class);
        $this->money->setAmount('string');
    }

    public function testGetEurAmount()
    {
        $this->money->setCurrency('USD', ['EUR', 'USD']);
        $this->money->setCurrencyRates(['USD' => 1.1497]);
        $this->money->setAmount(100);
        $this->assertEquals(86.979, $this->money->getEurAmount());
    }

    public function testInvalidCurrency()
    {
        $this->expectException(InvalidCurrencyException::class);
        $this->money->setCurrency('JPY', ['EUR', 'USD']);
    }

    public function testInvalidCurrencyRate()
    {
        $this->expectException(CurrencyNotFoundException::class);
        $this->money->getCurrencyRate('JPY');
    }
}