<?php

namespace Commission;

use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\User;

/**
 * Class PaymentCreator
 *
 * @package Commission
 */
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
        if (isset($array[0]) && is_array($array[0])) {
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
     * @throws \Commission\Exception\InvalidPaymentTypeException
     * @throws \Commission\Exception\WrongDateFormatException
     * @throws \Commission\Exception\WrongUserIdException
     */
    public function createPayment($array)
    {
        $payment = new Payment();
        $user = new User();
        $money = new Money(new Math());

        foreach ($array as $key => $element) {
            switch ($this->config['fields'][$key]) {
                case 'date':
                    $payment->setDate($element, $this->config['date_format']);
                    break;
                case 'user_id':
                    $user->setId($element);
                    break;
                case 'user_type':
                    $user->setType($element, $this->config['user_types']);
                    break;
                case 'payment_type':
                    $payment->setType($element, $this->config['payment_types']);
                    break;
                case 'payment_amount':
                    $money->setAmount($element);
                    break;
                case 'payment_currency':
                    $money->setCurrency($element, $this->config['currencies']);
                    break;
            }
        }

        $payment->setUser($user);
        $money->setCurrencyRates($this->config['currency_rates']);
        $payment->setMoney($money);

        return $payment;
    }
}