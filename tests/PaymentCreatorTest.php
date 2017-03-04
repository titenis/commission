<?php

namespace Commission\Tests;

use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\User;
use Commission\PaymentCreator;
use DateTime;
use PHPUnit\Framework\TestCase;

class PaymentCreatorTest extends TestCase
{
    /**
     * @var PaymentCreator
     */
    private $paymentCreator;
    private $paymentArray;
    private $config;

    public function setUp()
    {
        $this->paymentArray = [
            'date'             => '2016-12-12',
            'user_id'          => 2,
            'user_type'        => 'legal',
            'payment_type'     => 'cash_in',
            'payment_amount'   => 132,
            'payment_currency' => 'EUR'
        ];

        $keys = array_keys($this->paymentArray);

        $this->config = [
            'fields'         => array_combine($keys, $keys),
            'user_types'     => ['legal'],
            'payment_types'  => ['cash_in'],
            'date_format'    => 'Y-m-d',
            'currencies'     => ['EUR'],
            'currency_rates' => ['EUR' => 1]
        ];

        $this->paymentCreator = new PaymentCreator($this->config);
    }

    public function testCreatePayment()
    {
        $result = $this->paymentCreator->createPayment($this->paymentArray);

        $this->assertInstanceOf(Payment::class, $result);

        $paymentDate = $result->getDate();
        $paymentUser = $result->getUser();
        $paymentMoney = $result->getMoney();

        $this->assertInstanceOf(DateTime::class, $paymentDate);
        $this->assertEquals($paymentDate->format($this->config['date_format']), $this->paymentArray['date']);
        $this->assertInstanceOf(User::class, $paymentUser);
        $this->assertEquals($paymentUser->getId(), $this->paymentArray['user_id']);
        $this->assertInstanceOf(Money::class, $paymentMoney);
        $this->assertEquals($paymentMoney->getAmount(), $this->paymentArray['payment_amount']);
        $this->assertEquals($result->getType(), $this->paymentArray['payment_type']);
        $this->assertArraySubset($this->config['currency_rates'], $paymentMoney->getCurrencyRates());
    }

    public function testCreateFromArray()
    {
        $result = $this->paymentCreator->createFromArray([
            $this->paymentArray,
            $this->paymentArray
        ]);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);

        $result = $this->paymentCreator->createFromArray($this->paymentArray);
        $this->assertInstanceOf(Payment::class, $result);
    }
}