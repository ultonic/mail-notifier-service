<?php

namespace App\Foundations;

use App\Contracts\MailerInterface;
use App\Utils\MailMessage;


abstract class AbstractMailerProvider implements MailerInterface {
    protected $service;

    abstract function setBody();
    abstract function send(MailMessage $message);
}