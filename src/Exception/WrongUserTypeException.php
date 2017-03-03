<?php

namespace Commission\Exception;

/**
 * Class WrongUserTypeException
 *
 * @package Commission\Exception
 */
class WrongUserTypeException extends \Exception
{
    /**
     * WrongUserTypeException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Wrong user type.';

        parent::__construct($message, $code, $previous);
    }
}