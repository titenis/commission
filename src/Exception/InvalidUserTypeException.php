<?php

namespace Commission\Exception;

class InvalidUserTypeException extends \Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Invalid user type supplied.';

        parent::__construct($message, $code, $previous);
    }
}