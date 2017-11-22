<?php

namespace AppBundle\Services;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ExampleConsumer implements ConsumerInterface
{
    public function __construct()
    {
        echo ExampleConsumer::class . " is listening \r\n";
    }

    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        $message = unserialize($msg->getBody());
        echo 'received message '.$message['id']. ', created at '.$message['datetime']. "\r\n";
        sleep(1);
    }
}