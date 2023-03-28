<?php

namespace App\Lib;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

class Logger
{
    private static $logger = null;

    private $log = null;

    public static function getLogger() : Logger {
        if (!self::$logger)
            self::$logger = new self();
        return self::$logger;
    }

    /**
     * Logger Constructor
     */
    public function __construct() {
        try {
            $channels = [
                new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM,
                                    Monolog::DEBUG),
                new StreamHandler(LOG_LOCATION, Monolog::DEBUG),
                new NativeMailerHandler(CONFIG_ADMINEMAIL,
                                        "Critical Error",
                                        CONFIG_ADMINEMAIL,
                                        Monolog::ALERT),
            ];

            $this->log = new Monolog('Auction');
            foreach($channels as $channel) {
                $this->log->pushHandler($channel);
            }
        } catch (\Exception $e) {
            error_log("Critical Failure");
            die();
        }
    }

    /**
     * Log an emergency message to the logs.
     * @param       $message
     * @param array $context
     */
    public function emergency($message, array $context = []) {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an alert message to the logs.
     * @param       $message
     * @param array $context
     */
    public function alert($message, array $context = []) {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a critcal message to the logs.
     * @param       $message
     * @param array $context
     */
    public function critical($message, array $context = []) {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an error message to the logs.
     * @param       $message
     * @param array $context
     */
    public function error($message, array $context = []) {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a warning message to the logs.
     * @param       $message
     * @param array $context
     */
    public function warning($message, array $context = []) {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a notice message to the logs.
     * @param       $message
     * @param array $context
     */
    public function notice($message, array $context = []) {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an info message to the logs.
     * @param       $message
     * @param array $context
     */
    public function info($message, array $context = []) {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a debug message to the logs.
     * @param       $message
     * @param array $context
     */
    public function debug($message, array $context = []) {
        $this->writeLog(__FUNCTION__, $message, $context);
    }




    /**
     * Log a message to the logs.
     * @param       $level
     * @param       $message
     * @param array $context
     */
    public function log($level, $message, array $context = []) {
        $this->writeLog($level, $message, $context);
    }

    /**
     * Dynamically pass log calls into the writer
     * @param       $level
     * @param       $message
     * @param array $context
     */
    public function write($level, $message, array $context = []) {
        $this->writeLog($level, $message, $context);
    }


    /**
     * Write a message to the logs.
     * @param $level
     * @param $message
     * @param $context
     */
    protected function writeLog($level, $message, $context) {
        $message = $this->formatMessage($message);
        $this->log->{$level}($message, $context);
    }

    /**
     * Format the parameters for the logger.
     * @param $message
     * @return mixed
     */
    public function formatMessage($message) {
        if(is_array($message)) {
            return var_export($message, true);
        }

        return $message;
    }
}
