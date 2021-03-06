<?php

namespace Commission\Exception;

/**
 * Class WrongUserIdException
 *
 * @package Commission\Exception
 */
class WrongUserIdException extends \Exception
{
    /**
     * WrongUserIdException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Wrong user id supplied.';

        parent::__construct($message, $code, $previous);
    }
}