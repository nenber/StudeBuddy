<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\ReportUserType;

class ReportUserController extends AbstractController
{
    /**
     * @Route("/user/{id}/report", name="report", methods={"GET","POST"})
     */
    public function reportUser(User $user, UserRepository $userRepository, Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ReportUserType::class, $user);
        $form->handleRequest($request);
        $currentUser = $this->getUser();
        $currentUserSpokenLangage = $currentUser->getSpokenLanguage();
        $currentUserLTL = $currentUser->getLanguageToLearn();
        $buddyLTL = $user->getLanguageToLearn();
        $buddySL = $user->getSpokenLanguage();
        //GP
        if(($user->getIsGodson() && $currentUser->getIsGodParent()) || in_array('ROLE_ADMIN', $currentUser->getRoles())){
            if (!empty(array_intersect($buddyLTL, $currentUserSpokenLangage))) {
                if ($form->isSubmitted() && $form->isValid()) {
                    // set report user status to true
                    $user->setIsReported(true);
                    $user->setReportedBy($this->getUser());
                    $this->getDoctrine()->getManager()->flush();
                    $this->addFlash("successReport", "Votre signalement a bien été enregistré et sera traité dans les plus brefs délais.");
                    
                    return $this->redirectToRoute('app_index');
                }
                
                return $this->render('report_user/index.html.twig', [
                    'user' => $user,
                    'users' => $userRepository->findAll(),
                    'form' => $form->createView(),
                ]);
            }
        }//GS
        elseif(($currentUser->getIsGodson() && $user->getIsGodParent()) || in_array('ROLE_ADMIN', $currentUser->getRoles())){
            if (!empty(array_intersect($buddySL, $currentUserLTL))) {
                if ($form->isSubmitted() && $form->isValid()) {
                    // set report user status to true
                    $user->setIsReported(true);
                    $user->setReportedBy($this->getUser());
                    $this->getDoctrine()->getManager()->flush();
                    $this->addFlash("successReport", "Votre signalement a bien été enregistré et sera traité dans les plus brefs délais.");
                    
                    return $this->redirectToRoute('app_index');
                }
                return $this->render('report_user/index.html.twig', [
                    'user' => $user,
                    'users' => $userRepository->findAll(),
                    'form' => $form->createView(),
                ]);
            }
        }
        else {
                $this->addFlash("error", "Vous ne pouvez pas report ce user");
                return $this->redirectToRoute('app_index');
        } 

        if ($form->isSubmitted() && $form->isValid()) {
            // set report user status to true
            $user->setIsReported(true);
            $user->setReportedBy($this->getUser());

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("successReport", "Votre signalement a bien été enregistré et sera traité dans les plus brefs délais.");
            
            return $this->redirectToRoute('app_index');
        }
        

        return $this->render('report_user/index.html.twig', [
            'user' => $user,
            'users' => $userRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/user/{id}/block", name="block", methods={"GET","POST"})
    //  */
    // public function blockUser(User $user, Request $request): Response
    // {

    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    //     $user_id[] = $user->getId();
    //     $this->getUser()->setBlacklist($user_id);
    //     $this->getDoctrine()->getManager()->flush();

    //     $this->addFlash('blockedUser', "Vous avez bloqué cet utilisateur");
    //     return $this->redirectToRoute('app_index');
    // }
}
