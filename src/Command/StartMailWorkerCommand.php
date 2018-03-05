<?php

namespace App\Command;

use App\Repository\MailTemplateRepository;
use Pheanstalk\Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Pheanstalk\Pheanstalk;

use App\Utils\MailHandler;
use App\Utils\MailMessage;



class StartMailWorkerCommand extends \Symfony\Component\Console\Command\Command
{
    protected $handler;
    protected $template;
    protected $queue;

    function __construct($name = null, MailHandler $mailHandler, MailTemplateRepository $template)
    {
        $this->handler = $mailHandler;
        $this->template = $template;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('pheanstalk:start')
            ->setDescription('Start beanstalkd dispatcher');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        while($this->handler->queueManager->isConnect()) {
            try {
                $record = $this->handler->queueManager->getRecord();
                $message = $this->handler->queueManager->createMessage($record->getData(), $this->template);

                $this->handler->mailer->send($message);
                $output->writeln('Отправлено письмо на почту ' . $message->to);

                $this->handler->queueManager->removeRecord($record);
                echo 'Задача id:' . $record->getId() .' удалена!' . PHP_EOL;
            } catch (Exception $e) {
                $this->handler->queueManager->writeLog($e->getMessage());
                $output->writeln($e->getMessage());
            }

        }
    }
}