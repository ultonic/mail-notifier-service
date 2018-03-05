<?php

namespace App\Contracts;

interface QueueInterface {
    function getRecord();
    function addRecord(string $message);
    function isConnect();
    function removeRecord($record);
}