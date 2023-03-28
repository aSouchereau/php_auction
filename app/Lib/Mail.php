<?php

namespace App\Lib;

use App\Exceptions\MailException;

/**
 * Class Mail
 * @package App\Lib
 */
class Mail
{
    /**
     * Send mail via php internal call
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool
     */
    public static function sendMail(string $to, string $subject, string $body): bool {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $result = mail($to, $subject, $body, $headers);
        if (!$result)
            throw new MailException("Internal Error: Cannot send mail");
        return $result;
    }
}