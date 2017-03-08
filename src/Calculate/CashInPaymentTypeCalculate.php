<?php

namespace Commission\Calculate;

use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\MathInterface;

/**
 * Class CashInPaymentTypeCalculate
 *
 * @package Commission\Calculate
 */
class CashInPaymentTypeCalculate implements CommissionCalculateInterface
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
                $config['fees']['in']['commission_fee_percent'],
                null,
                $config['fees']['in']['max_fee']
            ) * $money->getCurrentCurrencyRate()
        );
    }
}