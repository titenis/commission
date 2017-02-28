<?php

namespace Commission\Exception;

class InvalidPaymentTypeException extends \Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Invalid payment type supplied.';

        parent::__construct($message, $code, $previous);
    }
}