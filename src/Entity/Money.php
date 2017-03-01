<?php

namespace Commission\Entity;

use Commission\Exception\CurrencyNotFoundException;
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
     * @var array
     */
    private $currencyRates;

    public function getEurAmount()
    {
        $amount = $this->getAmount();
        $currencyRate = $this->getCurrencyRate($this->getCurrency());

        return $amount / $currencyRate;
    }

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
     * @param $currency
     * @return mixed
     * @throws CurrencyNotFoundException
     */
    public function getCurrencyRate($currency)
    {
        $currencyRates = $this->getCurrencyRates();

        if (!isset($currencyRates[$currency])) {
            throw new CurrencyNotFoundException;
        }

        return $currencyRates[$currency];
    }

    /**
     * @return array
     */
    public function getCurrencyRates()
    {
        return $this->currencyRates;
    }

    /**
     * @param array $currencyRates
     */
    public function setCurrencyRates($currencyRates)
    {
        $this->currencyRates = $currencyRates;
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
