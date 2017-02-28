<?php

namespace Commission\Exception;

class InvalidCurrencyException extends \Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Invalid currency supplied.';

        parent::__construct($message, $code, $previous);
    }
}