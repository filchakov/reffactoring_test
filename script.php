<?php

require('bootstrap.php');

$emailService = new EmailManager(true);
$emailService->send();