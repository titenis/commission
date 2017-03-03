<?php

namespace Commission\Exception;

/**
 * Class InvalidAmountException
 *
 * @package Commission\Exception
 */
class InvalidAmountException extends \Exception
{
    /**
     * InvalidAmountException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Invalid amount supplied.';

        parent::__construct($message, $code, $previous);
    }
}