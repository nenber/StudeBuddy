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
    public function forgetPassword(Request $request,MailerInterface $mailer)
    {

        // $mailer->send($email);
        if($request->request->get("email") != null )
        {
            $result = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['email' => $request->request->get("email")]);
            $em = $this->getDoctrine()->getManager();


            if($result == null)
            {
                return $this->render('forget-password.html.twig', [
                            'controller_name' => 'UserController',
                        ]);
            }
            else{
                $uni = $result->getEmail();
                $token = sha1(random_bytes(strlen($uni)));
                $result->setToken($token);
                $em->persist($result);
                $em->flush();
                dump($result);
                $url = $this->generateUrl('user_reset_password',["token" => $result->getToken()]);

                // $restPasswordPage = $this->generateUrl('reset_password',array("token"=>$token));
              
                $email = (new Email())
                ->from('noreply@studebuddy.com')
                ->to($request->request->get("email"))
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Changement de mot de passe')
                ->text("Veuillez cliquer sur le lien pour reinitialiser votre mot de passe :"."http://0.0.0.0:8082".$url);

                $mailer->send($email);

            }
            

        


        }
        return $this->render('user/forget-password.html.twig', [
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
        if($result != null)
        {
            return $this->render('user/reset-password.html.twig', [
                        'controller_name' => 'UserController',
                        "email" => $result->getEmail()
                    ]);
        }
        else
        {
            return $this->redirectToRoute("default_index");
        }

        
    }

    /**
     * @Route("/change_password/{email}", name="change_password")
     */
    public function changePassword(Request $request,$email,UserPasswordEncoderInterface $passwordEncoder) 
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($result != null) {
            $newMdp  = $request->request->get("inputMdp");
            $result->setPassword(
                $passwordEncoder->encodePassword(
                    $result,
                    $newMdp
                )
            );
            $em->persist($result);
            $em->flush();
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
}