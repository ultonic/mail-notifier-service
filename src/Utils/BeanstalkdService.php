<?php

namespace App\Utils;

use Pheanstalk\Pheanstalk;
use App\Foundations\AbstractQueueProvider;


class BeanstalkdService extends AbstractQueueProvider {

    public $tube;

    public function __construct(string $tube, Pheanstalk $queueProvider)
    {
        $this->service = $queueProvider;
        $this->tube = $tube;
    }

    public function getRecord()
    {
        return $this->service->watch($this->tube)->reserve();
    }

    public function addRecord(string $message)
    {
        $this->service->useTube($this->tube)->put($message . PHP_EOL);
    }

    public function isConnect()
    {
        return $this->service->getConnection()->isServiceListening();
    }

    public function removeRecord($record)
    {
        return $this->service->delete($record);
    }

    public function writeLog($message)
    {
        //TODO implement method
    }

}