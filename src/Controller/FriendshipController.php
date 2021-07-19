<?php

namespace App\Controller;

use App\Entity\Friendship;
use App\Entity\User;
use App\Form\FriendType;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FriendshipRepository;

class FriendshipController extends AbstractController
{
    /**
     * @Route("/friendship", name="friendship")
     */
    public function index(): Response
    {
        return $this->render('friendship/index.html.twig', [
            'controller_name' => 'FriendshipController',
        ]);
    }

    /**
     * @Route("/friendship/new/{id}", name="friendship_new_id", methods={"GET","POST"})
     */
    public function addFriend(Request $request, User $user, FriendshipRepository $friendshipRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $ami = new Friendship();
        $currentUser = $this->getUser();

        $friendships = $friendshipRepository->findAll();
        foreach($friendships as $friendship){
            if ($friendship->getUser()->getId() == $currentUser->getId() && $friendship->getFriend()->getId() == $user->getId() && $friendship->getHasBeenHelpful(true)){
                $this->addFlash(
                    'error',
                    'Accès interdit.'
                );
                return $this->redirectToRoute('app_index');
            }
        }

        $entityManager = $this->getDoctrine()->getManager();
        $ami->setUser($currentUser);
        $ami->setFriend($user);
        $ami->setHasBeenHelpful(true);
        $entityManager->persist($ami);
        $entityManager->flush();

        $this->addFlash(
            'noticeGood',
            'Bien ! Tu es connecté(e) à cet utilisateur !'
        );

        return $this->redirectToRoute('messagerie');


    }

    /**
     * @Route("/friendship/{id}", name="friendship_delete_id")
     */
    public function deleteFriend(Friendship $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if($this->getUser()->getId() !== $user->getUser()->getId()){
            $this->addFlash(
                'error',
                'Accès interdit.'
            );
            return $this->redirectToRoute('app_index');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $user->setHasBeenHelpful(false);
        $entityManager->flush();

        $this->addFlash(
            'noticeDisconnect',
            'Ok ! Tu t\'es déconnecté de cet utilisateur !'
        );

        return $this->RedirectToRoute('messagerie');

//      TO DO flash  message

    }




}
