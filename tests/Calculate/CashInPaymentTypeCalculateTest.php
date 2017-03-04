<?php

namespace Commission\Tests;

use Commission\Calculate\CashInPaymentTypeCalculate;
use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\Math;
use PHPUnit\Framework\TestCase;

class CashInPaymentTypeCalculateTest extends TestCase
{
    /**
     * @var CashInPaymentTypeCalculate
     */
    private $cashInPaymentTypeCalculate;

    public function setUp()
    {
        $this->cashInPaymentTypeCalculate = new CashInPaymentTypeCalculate();
    }

    public function testCalculateCommission()
    {
        $config = [
            'fees' => [
                'in' => [
                    'commission_fee_percent' => 0.3,
                    'max_fee'                => 300
                ]
            ]
        ];
        $math = new Math();
        $payment = new Payment();
        $money = new Money($math);
        $money->setAmount(1000);
        $payment->setMoney($money);

        $this->assertEquals(3, $this->cashInPaymentTypeCalculate->calculateCommission(
            $payment,
            $math,
            new PaymentsCache($math),
            $config
        ));

        $config['fees']['in']['max_fee'] = 1;
        $this->assertEquals(1, $this->cashInPaymentTypeCalculate->calculateCommission(
            $payment,
            $math,
            new PaymentsCache($math),
            $config
        ));
    }
}