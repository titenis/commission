<?php

namespace Commission\Tests;

use Commission\Entity\PaymentsCache;
use Commission\Math;
use PHPUnit\Framework\TestCase;

class PaymentsCacheTest extends TestCase
{
    /**
     * @var PaymentsCache
     */
    private $paymentsCache;

    public function setUp()
    {
        $this->paymentsCache = new PaymentsCache(new Math());
    }

    public function testIncrementCount()
    {
        $this->setMockData();

        $primaryCount = $this->paymentsCache->getCount();
        $this->assertEquals(0, $primaryCount);

        $this->paymentsCache->incrementCount();
        $this->assertEquals(1, $this->paymentsCache->getCount());
        $this->paymentsCache->incrementCount();
        $this->assertEquals(2, $this->paymentsCache->getCount());
    }

    private function setMockData()
    {
        $this->paymentsCache->setUserId(2);
        $this->paymentsCache->setYear(2014);
        $this->paymentsCache->setWeek(30);
    }

    public function testExceedingCount()
    {
        $this->setMockData();
        $this->paymentsCache->incrementCount();

        $this->assertTrue($this->paymentsCache->countDoesNotExceed(2));

        $this->paymentsCache->incrementCount();
        $this->paymentsCache->incrementCount();
        $this->assertFalse($this->paymentsCache->countDoesNotExceed(2));
    }

    public function testSettersGetters()
    {
        $cache = ['myCache'];

        $this->paymentsCache->setCache($cache);

        $this->assertEquals($cache, $this->paymentsCache->getCache());
    }

    public function testAddToTotal()
    {
        $amount = 100;
        $additionalAmount = 50;

        $this->setMockData();
        $this->paymentsCache->addToTotal($amount);

        $this->assertEquals($amount, $this->paymentsCache->getTotal());

        $this->paymentsCache->addToTotal($additionalAmount);
        $this->assertEquals($amount + $additionalAmount, $this->paymentsCache->getTotal());
    }

    public function testTotalIsLessThan()
    {
        $this->setMockData();
        $this->paymentsCache->addToTotal(100);
        $this->assertTrue($this->paymentsCache->totalIsLessThan(200));
    }

    public function testTotalIsExceededByLimit()
    {
        $this->setMockData();
        $this->paymentsCache->addToTotal(1000);
        $this->assertTrue($this->paymentsCache->totalIsExceededByLimit(100, 1000));
        $this->assertFalse($this->paymentsCache->totalIsExceededByLimit(0, 1000));
    }
}