<?php

namespace Commission\Exception;

class InvalidAmountException extends \Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Invalid amount supplied.';

        parent::__construct($message, $code, $previous);
    }
}