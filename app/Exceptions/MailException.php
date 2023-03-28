<?php

namespace App\Exceptions;
/**
 * Class MailException
 * @package App\Exceptions
 */
use Exception;

class MailException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}