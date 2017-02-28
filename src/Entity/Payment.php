<?php

namespace Commission\Entity;

use DateTime;
use Commission\Exception\WrongDateFormatException;
use Commission\Exception\WrongUserIdException;
use Commission\Exception\InvalidAmountException;
use Commission\Exception\InvalidCurrencyException;
use Commission\Exception\InvalidPaymentTypeException;
use Commission\Exception\InvalidUserTypeException;

class Payment
{
    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $userId;
    private $userType;
    private $type;
    private $amount;
    private $currency;

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     * @param $format
     * @throws WrongDateFormatException
     */
    public function setDate($date, $format)
    {
        if (DateTime::createFromFormat($format, $date) == false) {
            throw new WrongDateFormatException;
        }

        $this->date = new DateTime($date);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param $userId
     * @throws WrongUserIdException
     */
    public function setUserId($userId)
    {
        if (ctype_digit($userId) == false) {
            throw new WrongUserIdException;
        }

        $this->userId = (int) $userId;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param $userType
     * @param $availableUserTypes
     * @throws InvalidUserTypeException
     */
    public function setUserType($userType, $availableUserTypes)
    {
        if (in_array($userType, $availableUserTypes) == false) {
            throw new InvalidUserTypeException;
        }

        $this->userType = $userType;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @param $availableTypes
     * @throws InvalidPaymentTypeException
     */
    public function setType($type, $availableTypes)
    {
        if (in_array($type, $availableTypes) == false) {
            throw new InvalidPaymentTypeException;
        }

        $this->type = $type;
    }

    /**
     * @return mixed
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
     * @return mixed
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
