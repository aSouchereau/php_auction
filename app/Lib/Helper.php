<?php

namespace App\Lib;

use App\Exceptions\ClassException;

/**
 * Trait Helper
 * @package App\Lib
 */
trait Helper {

    /**
     * Gets a property value or false in not exists
     * @param string $var
     * @return false
     */
    public function get(string $var) {
        if(property_exists(get_called_class(),$var)) {
            return $this->$var;
        } else {
            return false;
        }
    }

    /**
     * Sets property value or false if not exists
     * @param string $var
     * @param $value
     * @return $this|false
     */
    public function set(string $var, $value) {
        if(property_exists(get_called_class(), $var)) {
            $this->$var = $value;
            return $this;
        } else {
            return false;
        }
    }

    public static function displayError($errorCode) : string {
        if(!property_exists(get_called_class(), "errorArray"))
            throw new ClassException("Property name doesnt exist");
        if(array_key_exists($errorCode, static::$errorArray)) {
            return static::$errorArray[$errorCode];
        } else {
            throw new ClassException("Key doesnt exist");
        }
    }
}