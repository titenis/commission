<?php

namespace Commission\Calculate;

use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Commission\MathInterface;

/**
 * Interface CommissionCalculateInterface
 *
 * @package Commission\Calculate
 */
interface CommissionCalculateInterface
{
    /**
     * @param \Commission\Entity\Payment       $payment
     * @param \Commission\MathInterface        $math
     * @param \Commission\Entity\PaymentsCache $paymentsCache
     * @param                                  $config
     * @return mixed
     */
    public function calculateCommission(Payment $payment, MathInterface $math, PaymentsCache $paymentsCache, $config);
}