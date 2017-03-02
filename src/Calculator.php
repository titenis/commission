<?php

namespace Commission;

use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Datetime;

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
     */
    public function calculateSingleCommission(Payment $payment)
    {
        $money = $payment->getMoney();
        $user = $payment->getUser();
        $money->setCurrencyRates($this->config['currency_rates']);

        switch ($payment->getType()) {
            case 'cash_in':
                return $this->math->formatAndRound(
                    $this->math->calculateByPercentage(
                        $money->getAmount(),
                        $this->config['fees']['in']['commission_fee_percent'],
                        null,
                        $this->config['fees']['in']['max_fee']
                    )
                );
                break;
            case 'cash_out';
                return $this->getCashOutCommission(
                    $money,
                    $user->getType(),
                    $user->getId(),
                    $payment->getDate()
                );
                break;
        }
    }

    /**
     * @param \Commission\Entity\Money $money
     * @param                          $userType
     * @param                          $userId
     * @param                          $paymentDate
     * @return mixed
     */
    public function getCashOutCommission(Money $money, $userType, $userId, $paymentDate)
    {
        switch ($userType) {
            case 'natural':
                return $this->calculateWeeklyCommission(
                    $money,
                    $userId,
                    $paymentDate,
                    $this->config['fees']['out']['natural']['commission_fee_percent'],
                    $this->config['fees']['out']['natural']['free_payments_amount_per_week'],
                    $this->config['fees']['out']['natural']['free_payments_count_per_week']
                );
                break;

            case 'legal':
                return $this->math->formatAndRound(
                    $this->math->calculateByPercentage(
                        $money->getAmount(),
                        $this->config['fees']['out']['legal']['commission_fee_percent'],
                        $this->config['fees']['out']['legal']['min_fee']
                    )
                );
                break;
        }
    }

    /**
     * @param \Commission\Entity\Money $money
     * @param                          $userId
     * @param \Datetime                $paymentDate
     * @param                          $feePercentage
     * @param                          $freePaymentsAmountPerWeek
     * @param                          $freePaymentsCountPerWeek
     * @return mixed
     */
    public function calculateWeeklyCommission(
        Money $money,
        $userId,
        DateTime $paymentDate,
        $feePercentage,
        $freePaymentsAmountPerWeek,
        $freePaymentsCountPerWeek
    ) {
        $year = $paymentDate->format('Y');
        $weekNumber = $paymentDate->format('W');
        $amountEur = $money->getEurAmount();
        $amount = $money->getAmount();

        $this->paymentsCache->setUserId($userId);
        $this->paymentsCache->setYear($year);
        $this->paymentsCache->setWeek($weekNumber);
        $this->paymentsCache->addToTotal($amountEur);
        $this->paymentsCache->incrementCount();

        if ($this->paymentsCache->totalIsLessThan($freePaymentsAmountPerWeek) &&
            $this->paymentsCache->countDoesNotExceed($freePaymentsCountPerWeek)
        ) {
            $result = 0;
        } else {
            if ($this->paymentsCache->totalIsExceededByLimit($amountEur, $freePaymentsAmountPerWeek)) {
                // Get the amount which exceeds limit
                $amountToBeUsed = $this->math->sub($this->paymentsCache->getTotal(), $freePaymentsAmountPerWeek);
            } else {
                $amountToBeUsed = $amount;
            }

            $result = $this->math->calculateByPercentage($amountToBeUsed, $feePercentage);
        }

        return $this->math->formatAndRound($result);
    }
}