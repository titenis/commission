<?php

namespace Commission\Tests;

use Commission\Calculator;
use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\Entity\User;
use Commission\Exception\InvalidPaymentTypeException;
use Commission\Math;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @var Calculator
     */
    private $calculator;
    /**
     * @var Math
     */
    private $math;
    /**
     * @var PaymentsCache;
     */
    private $paymentsCache;

    public function setUp()
    {
        $config = [
            'fees' => [
                'in' => [
                    'commission_fee_percent' => 0.3,
                    'max_fee'                => 1000
                ]
            ]
        ];
        $this->math = new Math();
        $this->paymentsCache = new PaymentsCache($this->math);
        $this->calculator = new Calculator($config, $this->paymentsCache, $this->math);
    }

    public function testCalculateCommission()
    {
        $payment = $this->createPayment();

        $results = $this->calculator->calculateCommissions($payment);

        $this->assertTrue(isset($results[0]));
        $this->assertEquals(0.6, $results[0]);

        $payments = [
            $payment,
            $payment
        ];

        $results = $this->calculator->calculateCommissions($payments);

        $this->assertCount(2, $results);
        $this->assertEquals(0.6, $results[1]);

        $payment->setType('nonExisting', ['nonExisting']);
        $this->expectException(InvalidPaymentTypeException::class);
        $this->calculator->calculateCommissions($payment);
    }

    private function createPayment()
    {
        $payment = new Payment();
        $user = new User();
        $money = new Money($this->math);

        $user->setId(1);
        $payment->setUser($user);

        $money->setAmount(200);
        $money->setCurrency('EUR', ['EUR']);
        $money->setCurrencyRates(['EUR' => 1]);
        $payment->setMoney($money);
        $payment->setType('cash_in', ['cash_in']);

        $payment->setDate('2016-10-10', 'Y-m-d');

        return $payment;
    }
}