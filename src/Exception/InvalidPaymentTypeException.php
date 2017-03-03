<?php

namespace Commission\Exception;

/**
 * Class InvalidPaymentTypeException
 *
 * @package Commission\Exception
 */
class InvalidPaymentTypeException extends \Exception
{
    /**
     * InvalidPaymentTypeException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Invalid payment type supplied.';

        parent::__construct($message, $code, $previous);
    }
}