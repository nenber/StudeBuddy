<?php

namespace App\Controller;


use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * 
 * * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/map", name="event_map")
     */
    public function displayMap()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repository = $this->getDoctrine()->getRepository(Event::class);
        $events = $repository->findAll();
        return $this->render('event/map.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events
        ]);
    }

    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        if($user != null)
        {
            if($user->getIsGodParent() != true){
                $this->addFlash(
                    'error',
                    'Vous devez être connecté en tant que Buddy pour avoir accès à cette page.'
                );
                return $this->redirectToRoute('app_index');
            }
        }

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            ////////////////////////////////////////////////////////
            $req = $request->request->get("event");
            // // url encode the address
            $address = urlencode($req["address"]);

            // google map geocode api url
            $url = "http://api.positionstack.com/v1/forward?access_key=56ebc1cf8ff6963df4f34386870621f4&query={$address}";

            // get the json response
            $resp_json = file_get_contents($url);

            // decode the json
            $resp = json_decode($resp_json, true);
            // response status will be 'OK', if able to geocode given address 
            if($resp['data']!=null){
                $lat = $resp['data'][0]["latitude"];
                $lon = $resp['data'][0]["longitude"];
                $event->setLat($lat);
                $event->setLng($lon);
                    ///////////////////////////////////////////////////
                $event->setOrganizerId($this->getUser());
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($event);
                $entityManager->flush();

                return $this->redirectToRoute('event_index');
            }
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
        
    }

   

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        if($user != null)
        {
            if($user->getId() != $event->getOrganizerId()->getId()){
                $this->addFlash(
                    'error',
                    "Vous n'avez pas accès à cette page."
                );
                return $this->redirectToRoute('app_index');
            }
        }


        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_join", methods={"POST"})
     */
    public function join(Request $request, Event $event): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        if($user != null)
        {
            // if($user->getId() == $event->getOrganizerId()->getId()){
            //     $this->addFlash(
            //         'error',
            //         "Vous ne pouvez pas rejoindre cet événement."
            //     );
            //     return $this->redirectToRoute('event_map');
            // }
            // $entityManager = $this->getDoctrine()->getManager();
            //  $repository = $entityManager->getRepository(Event::class);
            //  $event = $repository->find($event->getOrganizerId()->getId());
            //  $event->addParticipantId($user->getId());
            //  $entityManager->flush($event);
        }


        

        $this->getDoctrine()->getManager();

        return $this->redirectToRoute('event_map');
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }


}
