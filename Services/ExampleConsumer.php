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
        $message = json_decode($msg->getBody(), true);
        $hcf = $this->calculateHighestCommonFactor($message["firstValue"], $message["secondValue"]);
        $message["hcf"] = $hcf;

        $data = $this->createDataObject(json_encode($message));
        $this->em->persist($data);
        $this->em->flush();

        echo 'received message ' . $message['id'] . ', created at ' . $message['datetime'] . ",\r\n" .
            "highest common factor of " . $message["firstValue"] . " and " . $message["secondValue"] . " is " . $hcf . "\r\n";
//        sleep(0.1);
    }

    /**
     * Calculate highest common factor of two numbers.
     * @see http://funkcje.net/view/2/3304/index.html
     *
     * @param $a first value
     * @param $b second value
     *
     * @return int highest common factor
     */
    private function calculateHighestCommonFactor($a, $b)
    {
        $a = (int)$a;
        $b = (int)$b;

        while ($a !== $b) {
            if ($a < $b) {
                $helper = $a;
                $a = $b;
                $b = $helper;
            }
            $a = $a - $b;
        }
        return $a;
    }

    private function createDataObject($desc)
    {
        $data = new Data();
        $data->setDescription($desc);
        return $data;
    }
}