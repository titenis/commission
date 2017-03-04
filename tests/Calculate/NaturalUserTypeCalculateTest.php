<?php

namespace Commission\Tests;

use Commission\Calculate\NaturalUserTypeCalculate;
use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\Entity\User;
use Commission\Math;
use PHPUnit\Framework\TestCase;

class NaturalUserTypeCalculateTest extends TestCase
{
    /**
     * @var NaturalUserTypeCalculate
     */
    private $naturalUserTypeCalculate;

    public function setUp()
    {
        $this->naturalUserTypeCalculate = new NaturalUserTypeCalculate();
    }

    public function testCalculateCommission()
    {
        $config = [
            'fees' => [
                'out' => [
                    'natural' => [
                        'commission_fee_percent'        => 0.3,
                        'free_payments_amount_per_week' => 1000,
                        'free_payments_count_per_week'  => 1,
                    ]
                ]
            ]
        ];
        $math = new Math();
        $payment = new Payment();
        $user = new User();
        $paymentsCache = new PaymentsCache($math);
        $money = new Money($math);

        $user->setId(1);
        $payment->setUser($user);

        $money->setAmount(200);
        $money->setCurrency('EUR', ['EUR']);
        $money->setCurrencyRates(['EUR' => 1]);
        $payment->setMoney($money);

        $payment->setDate('2016-10-10', 'Y-m-d');

        $this->assertEquals(0, $this->naturalUserTypeCalculate->calculateCommission(
            $payment,
            $math,
            $paymentsCache,
            $config
        ));

        $money->setAmount(900);
        $payment->setMoney($money);
        $this->assertEquals(0.3, $this->naturalUserTypeCalculate->calculateCommission(
            $payment,
            $math,
            $paymentsCache,
            $config
        ));

        $money->setAmount(1000);
        $payment->setMoney($money);
        $this->assertEquals(3, $this->naturalUserTypeCalculate->calculateCommission(
            $payment,
            $math,
            $paymentsCache,
            $config
        ));
    }
}