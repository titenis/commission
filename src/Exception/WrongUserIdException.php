<?php

namespace Commission\Exception;

class WrongUserIdException extends \Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Wrong user id supplied.';

        parent::__construct($message, $code, $previous);
    }
}