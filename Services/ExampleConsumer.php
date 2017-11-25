<?php

namespace AppBundle\Services;

use AppBundle\Domain\HighestCommonFactorCalculator;
use AppBundle\Entity\Data;
use Doctrine\ORM\EntityManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Simple rabbitMq consumer
 * This class is initialize by a service.
 * To execute this code run the command:  php bin/console bbitmq:consumer <<queue name>>
 */
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
     * Receives data from the queue and executes the task.
     *
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        # message to array
        $message = json_decode($msg->getBody(), true);

        $hcfCalculator = new HighestCommonFactorCalculator();
        $message["hcf"] = $hcfCalculator->calculate($message["firstValue"], $message["secondValue"]);

        #create and save the data object
        $data = $this->createDataObject(json_encode($message));
        $this->em->persist($data);
        $this->em->flush();

        echo $this->getInfo($message);
//        sleep(0.1);

        return true;
    }

    /**
     * Preparing the message.
     *
     * @param array $message Data to show
     *
     * @return string
     */
    private function getInfo(array $message)
    {
        return 'received message ' . $message['id'] . ', created at ' . $message['datetime'] . ",\r\n" .
            "highest common factor of " . $message["firstValue"] . " and " . $message["secondValue"] . " is " . $message["hcf"] . "\r\n";
    }

    /**
     * Create object
     *
     * @param string $desc Json data
     *
     * @return Data
     */
    private function createDataObject($desc)
    {
        $data = new Data();
        $data->setDescription($desc);
        return $data;
    }
}