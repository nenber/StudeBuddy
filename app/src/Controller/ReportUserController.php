<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\ReportUserType;

class ReportUserController extends AbstractController
{
    /**
     * @Route("/user/{id}/report", name="report", methods={"GET","POST"})
     */
    public function reportUser(User $user, Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ReportUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // set report user status to true
            $user->setIsReported(true);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('report_user/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}/block", name="block", methods={"GET","POST"})
     */
    public function blockUser(User $user, Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user_id[] = $user->getId();
        $this->getUser()->setBlacklist($user_id);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('blockedUser', "Vous avez bloqué cet utilisateur");
        return $this->redirectToRoute('app_index');
    }
}
