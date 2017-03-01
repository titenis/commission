<?php

namespace Commission;

use Commission\Entity\Payment;
use Datetime;

class Calculator
{
    private $config;
    private $paymentsCache;

    /**
     * Calculator constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
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
                    $money->getEurAmount(),
                    $money->getAmount(),
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

        return $this->format($fee);
    }

    public function format($number)
    {
        return number_format($this->roundUp($number), 2);
    }

    public function roundUp($number, $precision = 2)
    {
        $fig = pow(10, $precision);

        return (ceil($number * $fig) / $fig);
    }

    public function getCashOutCommission($amountEur, $amountOriginal, $userType, $userId, $paymentDate)
    {
        switch ($userType) {
            case 'natural':
                return $this->calculateWeeklyCommission(
                    $amountEur,
                    $amountOriginal,
                    $userId,
                    $paymentDate,
                    $this->config['fees']['out']['natural']['commission_fee_percent'],
                    $this->config['fees']['out']['natural']['free_payments_amount_per_week'],
                    $this->config['fees']['out']['natural']['free_payments_count_per_week']
                );
                break;

            case 'legal':
                return $this->calculateSimpleCommission(
                    $amountOriginal,
                    $this->config['fees']['out']['legal']['commission_fee_percent'],
                    $this->config['fees']['out']['legal']['min_fee']
                );
                break;
        }
    }

    public function calculateWeeklyCommission(
        $amountEur,
        $amountOriginal,
        $userId,
        DateTime $paymentDate,
        $feePercentage,
        $freePaymentsAmountPerWeek,
        $freePaymentsCountPerWeek
    ) {
        $year = $paymentDate->format('Y');
        $weekNumber = $paymentDate->format('W');

        if (empty($this->paymentsCache[$userId][$year][$weekNumber]['total'])) {
            $this->paymentsCache[$userId][$year][$weekNumber]['total'] = $amountEur;
        } else {
            $this->paymentsCache[$userId][$year][$weekNumber]['total'] += $amountEur;
        }

        if (empty($this->paymentsCache[$userId][$year][$weekNumber]['count'])) {
            $this->paymentsCache[$userId][$year][$weekNumber]['count'] = 1;
        } else {
            $this->paymentsCache[$userId][$year][$weekNumber]['count']++;
        }

        if ($this->paymentsCache[$userId][$year][$weekNumber]['total'] < $freePaymentsAmountPerWeek &&
            $this->paymentsCache[$userId][$year][$weekNumber]['count'] <= $freePaymentsCountPerWeek
        ) {
            return $this->format(0);
        } else {
            return $this->calculateSimpleCommission(
                bcsub($this->paymentsCache[$userId][$year][$weekNumber]['total'], $amountEur) <
                $freePaymentsAmountPerWeek ? bcsub($this->paymentsCache[$userId][$year][$weekNumber]['total'],
                    $freePaymentsAmountPerWeek) : $amountOriginal,
                $feePercentage
            );
        }
    }
}