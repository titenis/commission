<?php

namespace Commission\Entity;

use Commission\Exception\InvalidUserTypeException;
use Commission\Exception\WrongUserIdException;

/**
 * Class User
 *
 * @package Commission\Entity
 */
class User
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $type;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @throws WrongUserIdException
     */
    public function setId($id)
    {
        if (ctype_digit($id) == false) {
            throw new WrongUserIdException;
        }

        $this->id = (int)$id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @param $availableTypes
     * @throws InvalidUserTypeException
     */
    public function setType($type, $availableTypes)
    {
        if (in_array($type, $availableTypes) == false) {
            throw new InvalidUserTypeException;
        }

        $this->type = $type;
    }
}
