<?php

namespace Commission\Entity;

use Commission\Exception\InvalidAmountException;
use Commission\Exception\InvalidCurrencyException;

/**
 * Class Money
 *
 * @package Commission\Entity
 */
class Money
{
    /**
     * @var float
     */
    private $amount;
    /**
     * @var string
     */
    private $currency;

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     * @throws InvalidAmountException
     */
    public function setAmount($amount)
    {
        if (is_numeric($amount) == false) {
            throw new InvalidAmountException;
        }

        $this->amount = 0 + $amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param $currency
     * @param $availableCurrency
     * @throws InvalidCurrencyException
     */
    public function setCurrency($currency, $availableCurrency)
    {
        if (in_array($currency, $availableCurrency) == false) {
            throw new InvalidCurrencyException;
        }

        $this->currency = $currency;
    }
}
