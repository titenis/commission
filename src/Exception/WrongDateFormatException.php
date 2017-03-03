<?php

namespace Commission\Exception;

/**
 * Class WrongDateFormatException
 *
 * @package Commission\Exception
 */
class WrongDateFormatException extends \Exception
{
    /**
     * WrongDateFormatException constructor.
     *
     * @param null            $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $message = 'Wrong date format supplied.';

        parent::__construct($message, $code, $previous);
    }
}