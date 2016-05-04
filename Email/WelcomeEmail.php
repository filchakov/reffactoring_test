<?php

require_once('Email.php');

class WelcomeEmail extends Email
{
    const SUBJECT = "Welcome as a new customer";

    const FROM = "info@forbytes.com";

    const BODY = "Hi [+email+] <br>We would like to welcome you as customer on our site!<br><br>Best Regards,<br>Forbytes Team";

    /**
     * @param string $to
     */
    public function __construct($to, $placeholders = [])
    {
        parent::__construct($to, self::FROM, self::SUBJECT, self::BODY, $placeholders);
    }

}