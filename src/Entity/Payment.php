<?php

namespace Commission\Entity;

use Commission\Exception\InvalidPaymentTypeException;
use Commission\Exception\WrongDateFormatException;
use DateTime;

/**
 * Class Payment
 *
 * @package Commission\Entity
 */
class Payment
{
    use TypedEntity;
    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var User
     */
    private $User;
    /**
     * @var Money
     */
    private $Money;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param User $User
     */
    public function setUser(User $User)
    {
        $this->User = $User;
    }

    /**
     * @return Money
     */
    public function getMoney()
    {
        return $this->Money;
    }

    /**
     * @param Money $Money
     */
    public function setMoney($Money)
    {
        $this->Money = $Money;
    }

    /**
     * @return DateTime
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
        $date = DateTime::createFromFormat($format, $date);

        if ($date == false) {
            throw new WrongDateFormatException;
        }

        $this->date = $date;
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
}
