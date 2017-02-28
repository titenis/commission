<?php

namespace Commission\Exception;

class WrongDateFormatException extends \Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Wrong date format supplied.';

        parent::__construct($message, $code, $previous);
    }
}