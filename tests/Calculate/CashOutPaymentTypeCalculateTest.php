<?php

namespace Commission\Tests;

use Commission\Calculate\CashOutPaymentTypeCalculate;
use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\Entity\User;
use Commission\Exception\InvalidUserTypeException;
use Commission\Math;
use PHPUnit\Framework\TestCase;

class CashOutPaymentTypeCalculateTest extends TestCase
{
    /**
     * @var CashOutPaymentTypeCalculate
     */
    private $cashOutPaymentTypeCalculate;

    public function setUp()
    {
        $this->cashOutPaymentTypeCalculate = new CashOutPaymentTypeCalculate();
    }

    public function testCalculateCommission()
    {
        $config = [
            'fees' => [
                'out' => [
                    'natural' => [
                        'commission_fee_percent'        => 0.3,
                        'free_payments_amount_per_week' => 1000,
                        'free_payments_count_per_week'  => 3
                    ]
                ]
            ]
        ];
        $payment = new Payment();
        $user = new User();
        $math = new Math();
        $money = new Money($math);
        $paymentCache = new PaymentsCache($math);

        $user->setId(1);
        $user->setType('natural', ['natural']);
        $payment->setUser($user);

        $payment->setDate('2016-10-10', 'Y-m-d');

        $money->setAmount(200);
        $money->setCurrency('EUR', ['EUR']);
        $money->setCurrencyRates(['EUR' => 1]);
        $payment->setMoney($money);

        $this->assertEquals(0, $this->cashOutPaymentTypeCalculate->calculateCommission(
            $payment,
            $math,
            $paymentCache,
            $config
        ));

        $money->setAmount(1000);
        $payment->setMoney($money);

        $this->assertEquals(0.6, $this->cashOutPaymentTypeCalculate->calculateCommission(
            $payment,
            $math,
            $paymentCache,
            $config
        ));

        $this->expectException(InvalidUserTypeException::class);
        $user->setType('nonExisting', ['nonExisting']);
        $payment->setUser($user);
        $this->cashOutPaymentTypeCalculate->calculateCommission(
            $payment,
            $math,
            $paymentCache,
            $config
        );
    }
}