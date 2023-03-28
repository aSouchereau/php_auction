<?php
namespace App\Exceptions;

use Exception;

/**
 * ClassException Class
 */
class ClassException extends Exception
{
    /**
     * Constructor of class
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * String representation of the exception
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}