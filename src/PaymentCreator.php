<?php

namespace Commission;

use Commission\Entity\Payment;

class PaymentCreator
{
    /**
     * @var
     */
    private $config;

    /**
     * PaymentCreator constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param $array
     * @return array|\Commission\Entity\Payment
     */
    public function createFromArray($array)
    {
        if (is_array($array[0])) {
            $payments = [];

            foreach ($array as $element) {
                $payments[] = $this->createPayment($element);
            }
        } else {
            $payments = $this->createPayment($array);
        }

        return $payments;
    }

    /**
     * @param $array
     * @return \Commission\Entity\Payment
     * @throws \Commission\Exception\InvalidAmountException
     * @throws \Commission\Exception\InvalidCurrencyException
     * @throws \Commission\Exception\InvalidPaymentTypeException
     * @throws \Commission\Exception\InvalidUserTypeException
     * @throws \Commission\Exception\WrongDateFormatException
     * @throws \Commission\Exception\WrongUserIdException
     */
    public function createPayment($array)
    {
        $payment = new Payment();

        foreach ($array as $key => $element) {
            switch ($this->config['fields'][$key]) {
                case 'date':
                    $payment->setDate($element, $this->config['date_format']);
                    break;
                case 'user_id':
                    $payment->setUserId($element);
                    break;
                case 'user_type':
                    $payment->setUserType($element, $this->config['user_types']);
                    break;
                case 'payment_type':
                    $payment->setType($element, $this->config['payment_types']);
                    break;
                case 'payment_amount':
                    $payment->setAmount($element);
                    break;
                case 'payment_currency':
                    $payment->setCurrency($element, $this->config['currencies']);
                    break;
            }
        }

        return $payment;
    }
}