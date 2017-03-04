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
    use TypedEntity;
    /**
     * @var int
     */
    private $id;

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
        if (filter_var($id, FILTER_VALIDATE_INT) == false) {
            throw new WrongUserIdException;
        }

        $this->id = (int)$id;
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
