<?php

require('bootstrap.php');

$emailService = new EmailService(true);
$emailService->send();