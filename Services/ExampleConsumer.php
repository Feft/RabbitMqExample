<?php

namespace AppBundle\Services;

use AppBundle\Entity\Data;
use Doctrine\ORM\EntityManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ExampleConsumer implements ConsumerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        echo ExampleConsumer::class . " is listening \r\n";
    }

    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        $message = json_decode($msg->getBody(),true);
        $data = $this->createDataObject($msg->getBody());
        $this->em->persist($data);
        $this->em->flush();
        echo 'received message '.$message['id']. ', created at '.$message['datetime']. "\r\n";
        sleep(0.1);
    }

    private function createDataObject($desc)
    {
        $data = new Data();
        $data->setDescription($desc);
        return $data;
    }
}