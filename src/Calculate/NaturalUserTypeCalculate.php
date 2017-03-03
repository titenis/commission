<?php

namespace Commission\Calculate;

use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\MathInterface;

/**
 * Class NaturalUserTypeCalculate
 *
 * @package Commission\Calculate
 */
class NaturalUserTypeCalculate implements CommissionCalculateInterface
{
    /**
     * @param \Commission\Entity\Payment       $payment
     * @param \Commission\MathInterface        $math
     * @param \Commission\Entity\PaymentsCache $paymentsCache
     * @param                                  $config
     * @return mixed
     */
    public function calculateCommission(Payment $payment, MathInterface $math, PaymentsCache $paymentsCache, $config)
    {
        $feePercentage = $config['fees']['out']['natural']['commission_fee_percent'];
        $freePaymentsAmountPerWeek = $config['fees']['out']['natural']['free_payments_amount_per_week'];
        $freePaymentsCountPerWeek = $config['fees']['out']['natural']['free_payments_count_per_week'];

        $paymentDate = $payment->getDate();
        $money = $payment->getMoney();
        $user = $payment->getUser();

        $year = $paymentDate->format('Y');
        $weekNumber = $paymentDate->format('W');

        $amountEur = $money->getEurAmount();
        $amount = $money->getAmount();

        $paymentsCache->setUserId($user->getId());
        $paymentsCache->setYear($year);
        $paymentsCache->setWeek($weekNumber);
        $paymentsCache->addToTotal($amountEur);
        $paymentsCache->incrementCount();

        if ($paymentsCache->totalIsLessThan($freePaymentsAmountPerWeek) &&
            $paymentsCache->countDoesNotExceed($freePaymentsCountPerWeek)
        ) {
            $result = 0;
        } else {
            if ($paymentsCache->totalIsExceededByLimit($amountEur, $freePaymentsAmountPerWeek)) {
                // Get the amount which exceeds limit
                $amountToBeUsed = $math->sub($paymentsCache->getTotal(), $freePaymentsAmountPerWeek);
            } else {
                $amountToBeUsed = $amount;
            }

            $result = $math->calculateByPercentage($amountToBeUsed, $feePercentage);
        }

        return $math->formatAndRound($result);
    }
}