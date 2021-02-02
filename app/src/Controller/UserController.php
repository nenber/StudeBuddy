<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Mailgun;
use App\Form\EditUserType;
use Symfony\Component\Mime\Email;
use App\Form\CustomUserAccountType;
use Symfony\Core\Component\Security\Util;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\UserRepository;




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
                return $this->render('user/forgot-password.html.twig', [
                    'controller_name' => 'UserController', "message_success" => "Email envoyé !", "email" => $request->request->get("email")
                ]);
            }
        }
        return $this->render('user/forgot-password.html.twig', [
            'controller_name' => 'UserController'
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
                $result->setToken(null);
                $em->persist($result);
                $em->flush();
                return $this->redirectToRoute("default_index");
            } else {
                return $this->redirectToRoute('user_reset_password', ['token' => $token]);
            }
        }
        dump($email);
        // return $this->redirectToRoute("default_index");
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
     * @Route("/uploadProfilImage", name="uploadProfilImage")
     */
    public function uploadProfileImage(Request $request)
    {
        dump($request);
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(User::class)->findOneBy(['email' => $request->request->get("email")]);
        if ($result != null) {
            $result->setProfileImage($request->request->get("image"));
            $em->persist($result);
            $em->flush();
        } else {
            dump("false");
        }

        return new JsonResponse();
    }
    /**
     * @Route("/edit-profile", name="edit-profile")
     */
    public function editProfil(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(CustomUserAccountType::class, $user);
        $form->handleRequest($request);
        // dump($request);die(0);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $parameters = $request->request->get("custom_user_account");
            $user->setSpokenLanguage($parameters["spokenLanguage"]);
            $user->setLanguageToLearn($parameters["languageToLearn"]);
            $user->setDescription($parameters["description"]);
            
            if (array_key_exists('isGodson', $parameters)) {
                if ($parameters["isGodson"] == "1") {
                    $user->setIsGodson(true);
                } else {
                    $user->setIsGodson(false);
                }
            } else {
                $user->setIsGodson(false);
            }
            if (array_key_exists('isGodparent', $parameters)) {
                if ($parameters["isGodparent"] == "1") {
                    $user->setIsGodparent(true);
                } else {
                    $user->setIsGodparent(false);
                }
            } else {
                $user->setIsGodparent(false);
            }
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');

            return $this->redirectToRoute('user_edit-profile');
        }
        if ($user->getProfileImage() != null) {
            $content = stream_get_contents($user->getProfileImage());
        } else {
            $content = null;
        }

        return $this->render('user/edit-profile.html.twig', [
            'formEditProfil' => $form->createView(),
            'profilImage' => $content
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $userMatchingLanguage = $subscribers = $buddies = array();
        $warning = $sorry = false;

        //si user is GP and GS => find all willing participant
        // match user SL and LTL with sub SL and LTL
        if (($user->getIsGodparent()) && ($user->getIsGodson())) {
            $subscribers = $repository->findByBuddies(true);
        }

        //si user is GP and not GS => find all GS
        // match user SL with GS LTL
        if (($user->getIsGodparent()) && ($user->getIsGodson() == false)) {
            $subscribers = $repository->findGodson(true);
            $userMatchingLanguage = $user->getSpokenLanguage();
        }
        //if user is GS and not GP => find all GP
        // match user LTL with GP SL
        if (($user->getIsGodson()) && ($user->getIsGodparent() == false)) {
            $subscribers = $repository->findGodparent(true);
            $userMatchingLanguage = $user->getLanguageToLearn();
        }

        //if user not GS and not GP => warning
        if (($user->getIsGodparent() == false) && ($user->getIsGodson() == false)) {
            $warning = true;
        }

        foreach ($subscribers as $person) {
            if ($person != $user) {
                // user is GS and !GP => match user LTL with GP SL
                if (($user->getIsGodson()) && ($user->getIsGodparent() == false)) {
                    $subscriberMatchingLanguage = $person->getSpokenLanguage();
                    if (!empty(array_intersect($subscriberMatchingLanguage, $userMatchingLanguage))) {
                        array_push($buddies, $person);
                    }
                }
                // user !GS and GP => match user LTL with GP SL
                if (($user->getIsGodson() == false) && ($user->getIsGodparent())) {
                    $subscriberMatchingLanguage = $person->getLanguageToLearn();
                    if (!empty(array_intersect($subscriberMatchingLanguage, $userMatchingLanguage))) {
                        array_push($buddies, $person);
                    }
                }
                // user GS GP => match subscriber SL w/ user LTL and subLTL w/userSL
                if (($user->getIsGodson()) && ($user->getIsGodparent())) {
                    $userSpokenLanguage = $user->getSpokenLanguage();
                    $userLanguageToLearn = $user->getLanguageToLearn();
                    $subscriberSpokenLanguage = $person->getSpokenLanguage();
                    $subscriberLanguageToLearn = $person->getLanguageToLearn();

                    if ((!empty(array_intersect($userSpokenLanguage, $subscriberLanguageToLearn)))
                        || (!empty(array_intersect($userLanguageToLearn, $subscriberSpokenLanguage)))
                    ) {
                        array_push($buddies, $person);
                    }
                }
            }
        }
        //if no buddies -> warning
        if (empty($buddies)) {
            $sorry = true;
        }

        return $this->render('user/matching.html.twig', [
            'buddies' => $buddies,
            'controller_name' => 'UserController',
            'warning' => $warning,
            'sorry' => $sorry,
        ]);
    }
}