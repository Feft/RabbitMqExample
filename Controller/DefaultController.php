<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * RabbitMq message publish
     *
     * @Route("/produce/{amount}", name="produce")
     * @param int amount Amount of messages to produce
     *
     * @return JsonResponse
     */
    public function messagePublishAction($amount)
    {
        for ($i=1;$i<$amount;$i++) {
           $this->get("old_sound_rabbit_mq.api_call_producer")->publish(json_encode($this->getData($i)));
        }
        return new JsonResponse();
    }

    /**
     * Test data.
     * @param int id 
     * @return string
     */
    private function getData($id)
    {
        $datetime = new \DateTime();
        return
            [
//                'id' => random_int(1, PHP_INT_MAX),
                'id' => $id,
                'desc' => 'Lorem ipsum',
                'datetime' => $datetime->format('Y-m-d H:i:s')
            ];
    }
}
