<?php

namespace Commission\Exception;

/**
 * Class InvalidCurrencyException
 *
 * @package Commission\Exception
 */
class InvalidCurrencyException extends \Exception
{
    /**
     * InvalidCurrencyException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Invalid currency supplied.';

        parent::__construct($message, $code, $previous);
    }
}