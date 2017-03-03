<?php

namespace Commission\Exception;

/**
 * Class InvalidUserTypeException
 *
 * @package Commission\Exception
 */
class InvalidUserTypeException extends \Exception
{
    /**
     * InvalidUserTypeException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Invalid user type supplied.';

        parent::__construct($message, $code, $previous);
    }
}