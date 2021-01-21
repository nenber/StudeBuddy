<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Mailgun;
use Symfony\Component\Mime\Email;
use Symfony\Core\Component\Security\Util;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\CustomUserAccountType;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\Session;



/**
 * Class UserController
 * @package App\Controller
 * 
 * * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/forget-password", name="forget-password")
     */
    public function forgetPassword(Request $request, MailerInterface $mailer)
    {

        // $mailer->send($email);
        if ($request->request->get("email") != null) {
            $result = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['email' => $request->request->get("email")]);
            $em = $this->getDoctrine()->getManager();


            if ($result == null) {
                return $this->render('user/forget-password.html.twig', [
                    'controller_name' => 'UserController',
                ]);
            } else {
                $uni = $result->getEmail();
                $token = sha1(random_bytes(strlen($uni)));
                $result->setToken($token);
                $em->persist($result);
                $em->flush();
                dump($result);
                $url = $this->generateUrl('user_reset_password', ["token" => $result->getToken()]);

                // $restPasswordPage = $this->generateUrl('reset_password',array("token"=>$token));

                $email = (new Email())
                    ->from('noreply@studebuddy.com')
                    ->to($request->request->get("email"))
                    //->cc('cc@example.com')
                    //->bcc('bcc@example.com')
                    //->replyTo('fabien@example.com')
                    //->priority(Email::PRIORITY_HIGH)
                    ->subject('Changement de mot de passe')
                    ->text("Veuillez cliquer sur le lien pour reinitialiser votre mot de passe :" . "http://0.0.0.0:8082" . $url);

                $mailer->send($email);
            }
        }
        return $this->render('user/forgot-password.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/reset_password/{token}", name="reset_password")
     */
    public function resetPassword($token)
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(User::class)->findOneBy(['token' => strval($token)]);
        if ($result != null) {
            return $this->render('user/reset-password.html.twig', [
                'controller_name' => 'UserController',
                "email" => $result->getEmail(),
                'token' => $result->getToken()
            ]);
        } else {
            return $this->redirectToRoute("default_index");
        }
    }

    /**
     * @Route("/change_password/{email}", name="change_password")
     */
    public function changePassword(Request $request, $email, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $token = $request->query->get('token');
        $result = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($result != null) {
            $newMdp  = $request->request->get("inputMdp");
            if (preg_match_all("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})^", $newMdp) > 0) {
                $result->setPassword(
                    $passwordEncoder->encodePassword(
                        $result,
                        $newMdp
                    )
                );
                $em->persist($result);
                $em->flush();
            } else {
                $this->redirectToRoute('user_reset_password', ['token' => $token]);
            }
        }
        return $this->redirectToRoute("default_index");
    }

    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function editUser(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Compte mis à jour');
            return $this->redirectToRoute('user_account');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account", name="account")
     */
    public function userAccount()
    {
        return $this->render('user/user-account.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/edit-profile", name="edit-profile")
     */
    public function editProfil(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(CustomUserAccountType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('message', 'Profile mis à jour');
            return $this->redirectToRoute('user_edit-profile');
        }
        return $this->render('user/edit-profile.html.twig', [
            'formEditProfil' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-password", name="edit-password")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            if ($request->request->get('pass') == $request->request->get('pass2')) {
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour !');

                return $this->redirectToRoute('user_account');
            } else {
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('user/edit-password.html.twig');
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function deleteUser(Request $request)
    {
        $user = $this->getUser();

        if ($user == null) {
            return $this->redirect($this->generateUrl('user_account'));
        }

        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();

            $em->remove($user);
            $em->flush();

            $this->get('security.context')->setToken(null);
            $this->get('request')->getSession()->invalidate();

            $request->getSession()->getFlashBag()->add('notice', "Votre compte a bien été supprimé.");

            return $this->redirect($this->generateUrl('user_account'));
        }

        return $this->render('user/delete-account.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/matching", name="matching")
     */

    public function findBuddy(UserRepository $repository)
    {
        $user = $this->getUser();
        $userLanguageToLearn = $user->getLanguageToLearn();
        $subcribers = $buddies = array();
        $warning = $sorry = false;
        if (($user->getIsGodparent()) && ($user->getIsGodson())) {
            $subcribers = $repository->findByPatronage(true);
        }
        if (($user->getIsGodparent()) && ($user->getIsGodson() == false)) {
            $subcribers = $repository->findGodson(true);
        }
        if (($user->getIsGodson()) && ($user->getIsGodparent() == false)) {
            $subcribers = $repository->findGodparent(true);
        }
        if (($user->getIsGodparent() == false) && ($user->getIsGodson() == false)) {
            $warning = true;
        }

        foreach ($subcribers as $person) {
            if ($person != $user) {
                $subcriberSpokenLanguage = $person->getSpokenLanguage();
                if (!empty(array_intersect($subcriberSpokenLanguage, $userLanguageToLearn))) {
                    array_push($buddies, $person);
                } else {
                    $sorry = true;
                }
            }
        }

        return $this->render('user/matching.html.twig', [
            'buddies' => $buddies,
            'controller_name' => 'UserController',
            'warning' => $warning,
            'sorry' => $sorry,
        ]);
    }
}
