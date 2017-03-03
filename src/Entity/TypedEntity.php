<?php

namespace Commission\Entity;

/**
 * Class TypedEntity
 *
 * @package Commission\Entity
 */
trait TypedEntity
{
    /**
     * @var
     */
    protected $type;

    /**
     * @return string
     */
    public function getCamelCasedType()
    {
        $explodedType = explode('_', $this->getType());

        return implode(array_map(function ($element) {
            return ucfirst($element);
        }, $explodedType));
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
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}