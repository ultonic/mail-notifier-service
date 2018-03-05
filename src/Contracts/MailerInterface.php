<?php

namespace App\Contracts;

use App\Utils\MailMessage;

interface MailerInterface {
    function setBody();
    function send(MailMessage $message);
}