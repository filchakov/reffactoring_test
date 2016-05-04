<?php

require('ILog.php');

class ConsoleMessage implements ILog
{

    public static function getMessage($message)
    {
        echo $message."\r\n";
    }
}