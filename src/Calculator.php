<?php

namespace Commission;

use Commission\Entity\Money;
use Commission\Entity\Payment;
use Commission\Entity\PaymentsCache;
use Datetime;

class Calculator
{
    private $config;
    private $paymentsCache;

    /**
     * Calculator constructor.
     *
     * @param                                  $config
     * @param \Commission\Entity\PaymentsCache $paymentsCache
     */
    public function __construct($config, PaymentsCache $paymentsCache)
    {
        $this->config = $config;
        $this->paymentsCache = $paymentsCache;
    }

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

    public function calculateSingleCommission(Payment $payment)
    {
        $money = $payment->getMoney();
        $user = $payment->getUser();
        $money->setCurrencyRates($this->config['currency_rates']);

        switch ($payment->getType()) {
            case 'cash_in':
                return $this->calculateSimpleCommission(
                    $money->getAmount(),
                    $this->config['fees']['in']['commission_fee_percent'],
                    null,
                    $this->config['fees']['in']['max_fee']
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

    public function calculateSimpleCommission($amount, $feePercentage, $min = null, $max = null)
    {
        $fee = $amount * $feePercentage / 100;

        if (isset($max) && $fee > $max) {
            $fee = $max;
        }

        if (isset($min) && $fee < $min) {
            $fee = $min;
        }

        return $this->formatAndRound($fee);
    }

    public function formatAndRound($number)
    {
        return number_format($this->roundUp($number), 2);
    }

    public function roundUp($number, $precision = 2)
    {
        $fig = pow(10, $precision);

        return (ceil($number * $fig) / $fig);
    }

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
                return $this->calculateSimpleCommission(
                    $money->getAmount(),
                    $this->config['fees']['out']['legal']['commission_fee_percent'],
                    $this->config['fees']['out']['legal']['min_fee']
                );
                break;
        }
    }

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
            return $this->formatAndRound(0);
        } else {
            return $this->calculateSimpleCommission(
                bcsub($this->paymentsCache->getTotal(), $amountEur) <
                $freePaymentsAmountPerWeek ? bcsub($this->paymentsCache->getTotal(),
                    $freePaymentsAmountPerWeek) : $amount,
                $feePercentage
            );
        }
    }
}