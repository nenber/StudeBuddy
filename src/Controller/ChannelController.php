<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\User;
use App\Form\ChannelType;
use App\Repository\ChannelRepository;
use App\Repository\FriendshipRepository;
use App\Repository\EventRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\WebLink\Link;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ChannelController extends AbstractController
{
    /**
     * @Route("/messagerie", name="messagerie", methods={"GET"})
     */
    public function getChannels(ChannelRepository $channelRepository, FriendshipRepository $friendshipRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('channel/index.html.twig', [
            'channels' => $channelRepository->findAll(),
            'friendships' => $friendshipRepository->findAll()
        ]);
    }


    /**
     * @Route("/messagerie/new/{id}", name="messagerie_new_id", methods={"GET","POST"})
     */
    public function newFormBaseOnUser(Request $request, User $user, ChannelRepository $channelRepository,UserRepository $userRepository): Response
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
                    &&  $channel->getGetParticipant()->getId() == $existingChannel->getGetParticipant()->getId())
                || ($channel->getAuthorId()->getId() == $existingChannel->getGetParticipant()->getId()
                    && $channel->getGetParticipant()->getId() == $existingChannel->getAuthorId()->getId()) )
            {
                $this->addFlash(
                    'error',
                    'Vous avez déjà une conversation avec cette personne.'
                );
                return $this->redirectToRoute('app_index');
            }
        }
        $pa = $userRepository->findOneBy(["id" => $channel->getGetParticipant()->getId()]);
        $entityManager->flush();
        return $this->redirectToRoute('chat', ['id' => $channel->getId(), "pa" => $pa]);


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

        if($channel->getAuthorId()->getId() == $this->getUser()->getId() or $channel->getGetParticipant()->getId() == $this->getUser()->getId()){
            $messages = $messageRepository->findBy([
                'channel' => $channel
            ], ['createdAt' => 'ASC']);
    
            return $this->render('channel/chat.html.twig', [
                'channel' => $channel,
                'friendships' => $friendshipRepository->findAll(),
                'messages' => $messages,
            ]);
        } else {
            $this->addFlash('error', "Vous n'avez pas accès à cette conversation.");
            return $this->redirectToRoute('app_index');
        }

        
    }


    /**
     * @Route("messagerie/{id}", name="show", methods="GET")
     */
    public function show(User $user, EventRepository $events) : Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('channel/profile.html.twig', [
            'User' => $user,
            'events' => $events->findAll()
        ]);
    }

    /**
     * @Route("messagerie/check", name="message_check", methods="POST")
     */
    public function checkMessage(Request $request,MessageRepository $messageRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $message = $messageRepository->findBy([
            'channel' => intval($request->request->get("id"))
        ], ['createdAt' => 'DESC']);
        $result = array();
        if(!empty(array_chunk($message, 10)[0]))
        {
            foreach(array_chunk($message, 10)[0] as $key=>$value)
            {
                $temp = [$value->getId(),$value->getAuthor()->getId(), $value->getContent(),$value->getCreatedAt()];
                array_push($result,$temp);
            }
        }

        return New JsonResponse($result);
    }
}