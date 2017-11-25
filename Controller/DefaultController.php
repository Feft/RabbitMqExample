<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * RabbitMq message publish
     *
     * @Route("/produce/{amount}", name="produce_message")
     * @param int $amount Amount of messages to produce
     *
     * @return JsonResponse
     */
    public function messagePublishAction($amount)
    {
        for ($i = 1; $i <= $this->calculateAmountOfData($amount); $i++) {
            $this->get("old_sound_rabbit_mq.api_call_producer")->publish(json_encode($this->getData($i)));
        }
        return new JsonResponse();
    }

    /**
     * Calculate the amount of data to produce, if no value is given, it returns 1.
     *
     * @param string|null $amount Amount of data to produce
     *
     * @return int
     */
    private function calculateAmountOfData($amount)
    {
        $amount = (int)$amount;
        return $amount > 0 ? $amount : 1;
    }

    /**
     * Test data.
     *
     * @param int $id
     *
     * @return string
     */
    private function getData($id)
    {
        $datetime = new \DateTime();
        return
            [
//                'id' => random_int(1, PHP_INT_MAX),
                'id' => $id,
                'firstValue' => random_int(1,500),
                'secondValue' => random_int(1,2048),
                'desc' => 'Lorem ipsum',
                'datetime' => $datetime->format('Y-m-d H:i:s')
            ];
    }
}
