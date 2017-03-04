<?php

namespace Commission;

use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\Exception\InvalidPaymentTypeException;

/**
 * Class Calculator
 *
 * @package Commission
 */
class Calculator
{
    /**
     * @var
     */
    private $config;
    /**
     * @var \Commission\Entity\PaymentsCache
     */
    private $paymentsCache;
    /**
     * @var \Commission\Math|\Commission\MathInterface
     */
    private $math;

    /**
     * Calculator constructor.
     *
     * @param                                  $config
     * @param \Commission\Entity\PaymentsCache $paymentsCache
     * @param \Commission\MathInterface        $math
     */
    public function __construct($config, PaymentsCache $paymentsCache, MathInterface $math)
    {
        $this->config = $config;
        $this->paymentsCache = $paymentsCache;
        $this->math = $math;
    }

    /**
     * @param $payments
     * @return array
     */
    public function calculateCommissions($payments)
    {
        $results = [];

        if (is_array($payments)) {
            foreach ($payments as $singlePayment) {
                $results[] = $this->calculateSingleCommission($singlePayment);
            }
        } else {
            $results[] = $this->calculateSingleCommission($payments);
        }

        return $results;
    }

    /**
     * @param \Commission\Entity\Payment $payment
     * @return mixed
     * @throws \Commission\Exception\InvalidPaymentTypeException
     */
    public function calculateSingleCommission(Payment $payment)
    {
        $className = '\\Commission\\Calculate\\' . $payment->getCamelCasedType() . 'PaymentTypeCalculate';

        if (!class_exists($className)) {
            throw new InvalidPaymentTypeException;
        }

        $calculate = new $className();

        return $calculate->calculateCommission($payment, $this->math, $this->paymentsCache, $this->config);
    }
}