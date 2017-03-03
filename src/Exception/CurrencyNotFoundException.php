<?php

namespace Commission\Exception;

/**
 * Class CurrencyNotFoundException
 *
 * @package Commission\Exception
 */
class CurrencyNotFoundException extends \Exception
{
    /**
     * CurrencyNotFoundException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Currency not found';

        parent::__construct($message, $code, $previous);
    }
}