<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @package App\Controller
 * 
 * * @Route("/event", name="event_")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     */
    public function index(): Response
    {

        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
        
    }

    /**
     * @Route("/map", name="map")
     */
    public function displayMap()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('event/map.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
}
