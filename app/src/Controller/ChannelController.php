<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\User;
use App\Form\ChannelType;
use App\Repository\ChannelRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\WebLink\Link;

class ChannelController extends AbstractController
{
    /**
     * @Route("/messagerie", name="messagerie", methods={"GET"})
     */
    public function getChannels(ChannelRepository $channelRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('channel/index.html.twig', [
            'channels' => $channelRepository->findAll()
        ]);
    }
    

    /**
     * @Route("/messagerie/new/{id}", name="messagerie_new_id", methods={"GET","POST"})
     */
    public function newFormBaseOnUser(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $channel = new Channel();
        $userA = $this->getUser();
        $form = $this->createForm(ChannelType::class, $channel);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $channel->setAuthorId($userA);
            $channel->setName($user->getFirstName());
            $channel->setGetParticipant($user);
            $entityManager->persist($channel);
            $entityManager->flush();
            return $this->redirectToRoute('chat', ['id' => $channel->getId()]);
        }

        return $this->render('channel/new.html.twig', [
            'channel' => $channel,
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }



    /**
     * @Route("/messagerie/chat/{id}", name="chat")
     */
    public function chat(
        Channel $channel,
        MessageRepository $messageRepository
    ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $messages = $messageRepository->findBy([
            'channel' => $channel
        ], ['createdAt' => 'ASC']);

//        $hubUrl = $this->getParameter('mercure.default_hub');
//        $this->addLink($request, new Link('mercure', $hubUrl));

        return $this->render('channel/chat.html.twig', [
            'channel' => $channel,
            'messages' => $messages
        ]);
    }

    /**
     * @Route("/messagerie/{id}/connected", name="connected", methods={"GET"})
     */
    public function isConnected(User $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user->setIsConnected(true);

        $this->addFlash(
            'noticeGood',
            'Bien ! Tu es parrain d\'un nouveau buddy !'
        );

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('messagerie');

    }

    /**
     * @Route("/messagerie/{id}/noconnected", name="noconnected", methods={"GET"})
     */
    public function noConnected(User $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user->setIsConnected(false);

        $this->addFlash(
            'noticeDisconnect',
            'Ok ! Tu t\'es déconnecté de ce buddy !'
        );

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('messagerie');
    }

    /**
     * @Route("messagerie/{id}", name="show", methods="GET")
     */
    public function show(User $user) : Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        return $this->render('channel/profile.html.twig', [
            'User' => $user,
        ]);
    }
}
