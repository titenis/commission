<?php

namespace Commission\Tests;

use Commission\Entity\Payment;
use Commission\Exception\InvalidPaymentTypeException;
use Commission\Exception\WrongDateFormatException;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    /**
     * @var Payment
     */
    private $payment;

    public function setUp()
    {
        $this->payment = new Payment();
    }

    public function testWrongDate()
    {
        $this->expectException(WrongDateFormatException::class);
        $this->payment->setDate('2016-01-01', 'Y-m-d H:i:s');
    }

    public function testSetWrongType()
    {
        $this->expectException(InvalidPaymentTypeException::class);
        $this->payment->setType('type', ['first_type', 'second_type']);
    }
}