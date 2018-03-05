<?php

namespace App\Utils;

use App\Utils\{
    BeanstalkdService, SwiftMailerService
};

class MailHandler {

    public $queueManager;
    public $mailer;

    public function __construct(BeanstalkdService $queueManager, SwiftMailerService $mailer)
    {
        $this->queueManager = $queueManager;
        $this->mailer = $mailer;

//        $this->execute();
    }

    public function execute()
    {
        $this->queueManager->addRecord('
            {
              "from": "\"Our service\" <service@example.com>",
              "to": "\"Иван Сидоров\" <ivan@example.com>",
              "template": "welcome",
              "data": {
                "NAME": "Иван Петрович",
                "EMAIL": "ivan@example.com",
                "ORGANIZATION": "ООО \"Сидоров и сыновья\"",
                "DEPARTMENT": "Логистика",
                "CONFIRMATION_URL": "http://service.example.com\/confirm\/ydZ99TeS2dizWrZj",
                "ABUSE_URL": "http://service.example.com\/abuse\/ydZ99TeS2dizWrZj"
              }
            }
        ');
    }

}