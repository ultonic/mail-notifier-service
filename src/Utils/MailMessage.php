<?php

namespace App\Utils;

class MailMessage {
    public $from;
    public $to;
    public $subject;
    public $body;

    public function __construct(string $from, string $to, string $subject, string $body)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }
}