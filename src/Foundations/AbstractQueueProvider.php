<?php

namespace App\Foundations;

use App\Contracts\QueueInterface;
use App\Utils\MailMessage;
use App\Repository\MailTemplateRepository;

use Pheanstalk\Exception;
use Twig_Loader_Array;
use Twig_Environment;

abstract class AbstractQueueProvider implements QueueInterface {
    protected $service;

    public function createMessage($record, MailTemplateRepository $template) : MailMessage
    {
        $preparedRecord = $this->getPreparedRecord($record);

        $currentTemplate = $template->findOneBy(['code' => $preparedRecord->template]);

        if ($currentTemplate) {
            $twigLoader =  new Twig_Loader_Array(array(
                'subject.html' => $currentTemplate->getSubject(),
                'body.html' => $currentTemplate->getBody()
            ));

            $twig = new Twig_Environment($twigLoader);
            $subject = $twig->render('subject.html', (array)$preparedRecord->data);
            $body = $twig->render('body.html', (array)$preparedRecord->data);;

            return new MailMessage($preparedRecord->from, $preparedRecord->to, $subject, $body);
        } else {
            throw new Exception('Шаблон не найден!');
        }


    }

    public function getPreparedRecord($record)
    {
        $recordData = json_decode($record);

        $recordData->prefixFrom = $this->getPrefix($recordData->from);
        $recordData->from = $this->getEmail($recordData->from);

        $recordData->prefixTo = $this->getPrefix($recordData->to);
        $recordData->to = $this->getEmail($recordData->to);

        return $recordData;
    }

    public function getPrefix(string $string)
    {
        preg_match('~[\"](.*)[\"]~' , $string, $res);

        return array_pop($res);
    }

    public function getEmail(string $string)
    {
        preg_match('~[\<](.*)[\>]~' , $string, $res);

        return array_pop($res);

    }
}