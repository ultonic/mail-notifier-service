<?php

namespace App\Utils;

use App\Foundations\AbstractMailerProvider;
use App\Utils\MailMessage;
use Swift_Message;

class SwiftMailerService extends AbstractMailerProvider {

    function __construct(\Swift_Mailer $mailer)
    {
        $this->service = $mailer;
    }

    function setBody()
    {
        // TODO: Implement setBody() method.
    }

    function send(MailMessage $message)
    {
        $obMessage = (new Swift_Message($message->subject))
            ->setFrom($message->from)
            ->setTo($message->to)
            ->setBody(
                $message->body
            );

        $this->service->send($obMessage);
    }

}