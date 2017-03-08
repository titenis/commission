<?php

namespace Commission\Calculate;

use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\MathInterface;

/**
 * Class LegalUserTypeCalculate
 *
 * @package Commission\Calculate
 */
class LegalUserTypeCalculate implements CommissionCalculateInterface
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
        $money = $payment->getMoney();

        return $math->formatAndRound(
            $math->calculateByPercentage(
                $money->getEurAmount(),
                $config['fees']['out']['legal']['commission_fee_percent'],
                $config['fees']['out']['legal']['min_fee']
            ) * $money->getCurrentCurrencyRate()
        );
    }
}