<?php

namespace Commission\Calculate;

use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\Exception\InvalidUserTypeException;
use Commission\MathInterface;

/**
 * Class CashOutPaymentTypeCalculate
 *
 * @package Commission\Calculate
 */
class CashOutPaymentTypeCalculate implements CommissionCalculateInterface
{
    /**
     * @param \Commission\Entity\Payment       $payment
     * @param \Commission\MathInterface        $math
     * @param \Commission\Entity\PaymentsCache $paymentsCache
     * @param                                  $config
     * @return mixed
     * @throws \Commission\Exception\InvalidUserTypeException
     */
    public function calculateCommission(Payment $payment, MathInterface $math, PaymentsCache $paymentsCache, $config)
    {
        $user = $payment->getUser();

        $className = '\\Commission\\Calculate\\' . $user->getCamelCasedType() . 'UserTypeCalculate';

        if (!class_exists($className)) {
            throw new InvalidUserTypeException;
        }

        $calculate = new $className();

        return $calculate->calculateCommission($payment, $math, $paymentsCache, $config);
    }
}