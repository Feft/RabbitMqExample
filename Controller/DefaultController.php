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
     * @Route("/produce", name="produce")
     */
    public function messagePublishAction()
    {
        $this->get("old_sound_rabbit_mq.api_call_producer")->publish(serialize($this->getData()));
        return new JsonResponse();
    }

    /**
     * Test data.
     *
     * @return string
     */
    private function getData()
    {
        $datetime = new \DateTime();
        return
            [
                'id' => random_int(1, PHP_INT_MAX),
                'desc' => 'Lorem ipsum',
                'datetime' => $datetime->format('Y-m-d H:i:s')
            ];
    }
}
