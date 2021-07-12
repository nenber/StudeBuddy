<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\ChannelRepository;
use App\Entity\User;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepository, ChannelRepository $channelRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'channels' => $channelRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/{id}/ban", name="ban", methods={"GET"})
     */
    public function banUser(User $user): Response
    {
        $user->setIsBanned(true);
        $user->setRoles(['']);
        $user->setIsReported(false);
        $user->setReportedBy(NULL);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/{id}/cancel-report", name="cancel_report", methods={"GET"})
     */
    public function cancelReportUser(User $user): Response
    {
        $user->setIsReported(false);
        $user->setReportReason("");
        $user->setReportedBy(NULL);
        
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('admin');
    }
}
