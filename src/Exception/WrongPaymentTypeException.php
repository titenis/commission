<?php

namespace Commission\Exception;

/**
 * Class WrongPaymentTypeException
 *
 * @package Commission\Exception
 */
class WrongPaymentTypeException extends \Exception
{
    /**
     * WrongPaymentTypeException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Wrong payment type.';

        parent::__construct($message, $code, $previous);
    }
}