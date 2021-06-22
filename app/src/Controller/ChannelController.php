<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\User;
use App\Repository\ChannelRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\WebLink\Link;

class ChannelController extends AbstractController
{
    /**
     * @Route("/messagerie", name="messagerie")
     */
    public function getChannels(ChannelRepository $channelRepository): Response
    {
        $channels = $channelRepository->findAll();

        return $this->render('channel/index.html.twig', [
            'channels' => $channels ?? []
        ]);
    }

    /**
     * @Route("/messagerie/chat/{id}", name="chat")
     */
    public function chat(
        Request $request,
        Channel $channel,
        MessageRepository $messageRepository
    ): Response
    {
        $messages = $messageRepository->findBy([
            'channel' => $channel
        ], ['createdAt' => 'ASC']);

        $hubUrl = $this->getParameter('mercure.default_hub');
        $this->addLink($request, new Link('mercure', $hubUrl));

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
        $user->setIsConnected(true);

        $this->addFlash(
            'notice',
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
        $user->setIsConnected(false);

        $this->addFlash(
            'notice',
            'Ok ! Tu t\'es déconnecté de ce buddy !'
        );

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('messagerie');
    }
}
