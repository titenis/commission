<?php

namespace Commission\Exception;

class CurrencyNotFoundException extends \Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Currency not found';

        parent::__construct($message, $code, $previous);
    }
}