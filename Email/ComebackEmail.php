<?php

require_once('Email.php');

class ComebackEmail extends Email
{
    const SUBJECT = "Welcome as a new customer";

    const FROM = "infor@forbytes.com";

    const BODY = "Hi [+email+]<br>We miss you as a customer. Our shop is filled with nice products. Here is a voucher that gives you 50 kr to shop for.<br>Voucher: [+voucher+]<br><br>Best Regards,<br>Forbytes Team";

    /**
     * @param string $to
     */
    public function __construct($to, $placeholders = [])
    {
        parent::__construct($to, self::FROM, self::SUBJECT, self::BODY, $placeholders);
    }

}