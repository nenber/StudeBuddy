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
    public function addFriend(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $ami = new Friendship();
        $currentUser = $this->getUser();

            $entityManager = $this->getDoctrine()->getManager();
            $ami->setUser($currentUser);
            $ami->setFriend($user);
            $ami->setHasBeenHelpful(true);
            $entityManager->persist($ami);
            $entityManager->flush();
        $this->addFlash(
            'noticeGood',
            'Bien ! Tu es parrain d\'un nouveau buddy !'
        );
            return $this->redirectToRoute('messagerie');


    }

    /**
     * @Route("/friendship/{id}", name="friendship_delete_id")
     */
    public function deleteFriend(Friendship $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

                $entityManager = $this->getDoctrine()->getManager();
                $user->setHasBeenHelpful(false);
                $entityManager->flush();

        $this->addFlash(
            'noticeDisconnect',
            'Ok ! Tu t\'es déconnecté de ce buddy !'
        );

        return $this->RedirectToRoute('messagerie');

//      TO DO flash  message

    }




}