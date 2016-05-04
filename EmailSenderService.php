<?php

class EmailSenderService
{


    const SUCCESS_MESSAGE = "All mails are sent, I hope...";
    const FAILED_MESSAGE = "Oops, something went wrong when sending mail (%s)";
    const DEBUG_MESSAGE_AFTER_SEND_EMAIL = "Send mail to: %s";

    /**
     * @var bool
     */
    protected $debug;

    /**
     * EmailSenderService constructor.
     * @param bool $debug
     */
    public function __construct($debug)
    {
        $this->setDebud($debug);
    }

    /**
     * @return boolean
     */
    public function isDebud()
    {
        return $this->debug;
    }

    /**
     * @param $debug
     * @return $this
     */
    private function setDebud($debug)
    {
        $this->debug = $debug;
        return $this;
    }



    /**
     * @return string
     */
    private function showReportMessage()
    {
        $message = $this->isDebud()? self::SUCCESS_MESSAGE : self::FAILED_MESSAGE;
        ConsoleMessage::getMessage($message);
    }

    /**
     * @param Email $emailObject
     * @return string
     * @throws Exception
     */
    public function sendEmailMessage(Email $emailObject)
    {
        if($this->isDebud()){
            ConsoleMessage::getMessage(sprintf(self::DEBUG_MESSAGE_AFTER_SEND_EMAIL, $emailObject->getTo()));
        }

        try {
            $result = mail($emailObject->getTo(), $emailObject->getSubject(), $emailObject->getBody(), $emailObject->getHeaders());
            if($result === false) {
                throw new Exception("Cannot send email");
            }
        } catch(Exception $e){
            ConsoleMessage::getMessage($result);
        }
    }
}