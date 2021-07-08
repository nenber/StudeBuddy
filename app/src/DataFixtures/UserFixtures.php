<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager) {
        // create admin user
        $user = new User();
        // password encoding
        $password = $this->encoder->encodePassword($user, 'Password$0');

        $user->setEmail('admin@studandbuddy.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($password);
        $user->setFirstName('Admini');
        $user->setLastName('Tracteur');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setIsGodparent(false);
        $user->setIsGodson(false);
        $user->setDescription("Je suis admin");

        $manager->persist($user);

        // create banned user
        $user = new User();
        // password encoding 
        $password = $this->encoder->encodePassword($user, 'Password$0');

        $user->setEmail('banned@studandbuddy.com');
        $user->setIsBanned(true);
        $user->setPassword($password);
        $user->setFirstName('Mais');
        $user->setLastName('Champs');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setSpokenLanguage(['fr']);
        $user->setLanguageToLearn(['fr']);
        $user->setIsGodparent(true);
        $user->setIsGodson(true);
        $user->setDescription("Je suis un vilain !");

        $manager->persist($user);

        // create 7 users
        $user = new User();
        // password encoding
        $password = $this->encoder->encodePassword($user, 'Password$0');

        $user->setEmail('adrien-pabien@studandbuddy.com');
        $user->setPassword($password);
        $user->setFirstName('Adrien');
        $user->setLastName('Pabien');
        $user->setProfileImage('https://picsum.photos/id/0/');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setSpokenLanguage(['fr']);
        $user->setLanguageToLearn(['fr']);
        $user->setIsGodparent(true);
        $user->setIsGodson(true);
        $user->setDescription("Voici ma description !");
        
        $manager->persist($user);

        $user = new User();
        $user->setEmail('lola-pamela@studandbuddy.com');
        $user->setPassword($password);
        $user->setFirstName('Lola');
        $user->setLastName('Pamela');
        $user->setProfileImage('https://picsum.photos/id/30/');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setSpokenLanguage(['fr']);
        $user->setLanguageToLearn(['fr']);
        $user->setIsGodparent(true);
        $user->setIsGodson(false);
        $user->setDescription("Voici ma description !");
        
        $manager->persist($user);

        $user = new User();
        $user->setEmail('ryan-tryan@studandbuddy.com');
        $user->setPassword($password);
        $user->setFirstName('Ryan');
        $user->setLastName('Tryan');
        $user->setProfileImage('https://picsum.photos/id/50/');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setSpokenLanguage(['fr']);
        $user->setLanguageToLearn(['fr']);
        $user->setIsGodparent(true);
        $user->setIsGodson(false);
        $user->setDescription("Voici ma description !");
        
        $manager->persist($user);

        $user = new User();
        $user->setEmail('romeo-trivago@studandbuddy.com');
        $user->setPassword($password);
        $user->setFirstName('Romeo');
        $user->setLastName('Trivago');
        $user->setProfileImage('https://picsum.photos/id/80/');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setSpokenLanguage(['fr']);
        $user->setLanguageToLearn(['fr']);
        $user->setIsGodparent(true);
        $user->setIsGodson(false);
        $user->setDescription("Voici ma description !");
        
        $manager->persist($user);

        $user = new User();
        $user->setEmail('lucas-andrea@studandbuddy.com');
        $user->setPassword($password);
        $user->setFirstName('Lucas');
        $user->setLastName('Andrea');
        $user->setProfileImage('https://picsum.photos/id/93/');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setSpokenLanguage(['fr']);
        $user->setLanguageToLearn(['fr']);
        $user->setIsGodparent(true);
        $user->setIsGodson(false);
        $user->setDescription("Voici ma description !");
        
        $manager->persist($user);

        $user = new User();
        $user->setEmail('nathalie-pi@studandbuddy.com');
        $user->setPassword($password);
        $user->setFirstName('Nathalie');
        $user->setLastName('Pi');
        $user->setProfileImage('https://picsum.photos/id/120/');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setSpokenLanguage(['fr']);
        $user->setLanguageToLearn(['fr']);
        $user->setIsGodparent(true);
        $user->setIsGodson(false);
        $user->setDescription("Voici ma description !");
        
        $manager->persist($user);

        $user = new User();
        $user->setEmail('buds-buddy@studandbuddy.com');
        $user->setPassword($password);
        $user->setFirstName('Buds');
        $user->setLastName('Buddy');
        $user->setProfileImage('https://picsum.photos/id/66/');
        $user->setPhoneNumber('0102030405');
        $user->setSchool('ESGI');
        $user->setCreatedAt(new \DateTime());
        $user->setSpokenLanguage(['fr']);
        $user->setLanguageToLearn(['fr']);
        $user->setIsGodparent(true);
        $user->setIsGodson(false);
        $user->setDescription("Voici ma description !");
        
        $manager->persist($user);

        $manager->flush();
    }

}
