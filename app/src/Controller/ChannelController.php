<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\User;
use App\Form\ChannelType;
use App\Repository\ChannelRepository;
use App\Repository\FriendshipRepository;
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
    public function newFormBaseOnUser(Request $request, User $user, ChannelRepository $channelRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $channel = new Channel();
        $userA = $this->getUser();
        $form = $this->createForm(ChannelType::class, $channel);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $channel->setAuthorId($userA);
        $channel->setName($user->getFirstName());
        $channel->setGetParticipant($user);
        $entityManager->persist($channel);

        foreach($channelRepository->findAll() as $existingChannel){
            if(($channel->getAuthorId()->getId() == $existingChannel->getAuthorId()->getId() 
                &&  $channel->getGetParticipant()->getId() == $existingChannel->getGetParticipant()->getId()))
            {
                $this->addFlash(
                        'error',
                        'Vous avez déjà une conversation avec cette personne.'
                );
                return $this->redirectToRoute('app_index');
            }
        }
        $entityManager->flush();
        return $this->redirectToRoute('chat', ['id' => $channel->getId()]);


    }



    /**
     * @Route("/messagerie/chat/{id}", name="chat")
     */
    public function chat(
        Channel $channel,
        MessageRepository $messageRepository, FriendshipRepository $friendshipRepository
    ): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $messages = $messageRepository->findBy([
            'channel' => $channel
        ], ['createdAt' => 'ASC']);

        return $this->render('channel/chat.html.twig', [
            'channel' => $channel,
            'friendships' => $friendshipRepository->findAll(),
            'messages' => $messages
        ]);
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
