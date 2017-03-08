<?php

namespace Commission\Tests;

use Commission\Calculate\LegalUserTypeCalculate;
use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\Math;
use PHPUnit\Framework\TestCase;

class LegalUserTypeCalculateTest extends TestCase
{
    /**
     * @var LegalUserTypeCalculate
     */
    private $legalUserTypeCalculate;

    public function setUp()
    {
        $this->legalUserTypeCalculate = new LegalUserTypeCalculate();
    }

    public function testCalculateCommission()
    {
        $config = [
            'fees' => [
                'out' => [
                    'legal' => [
                        'commission_fee_percent' => 0.3,
                        'min_fee'                => 10
                    ]
                ]
            ]
        ];
        $math = new Math();
        $payment = new Payment();
        $money = new Money($math);
        $money->setAmount(1000);
        $money->setCurrency('EUR', ['EUR']);
        $money->setCurrencyRates(['EUR' => 1]);
        $payment->setMoney($money);

        $this->assertEquals(10, $this->legalUserTypeCalculate->calculateCommission(
            $payment,
            $math,
            new PaymentsCache($math),
            $config
        ));

        $config['fees']['out']['legal']['min_fee'] = 1;
        $this->assertEquals(3, $this->legalUserTypeCalculate->calculateCommission(
            $payment,
            $math,
            new PaymentsCache($math),
            $config
        ));
    }
}