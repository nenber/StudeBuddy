<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return User[] Returns an array of User objects
     */

    public function findByLanguageToLearn($language_to_learn)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $query = "SELECT * FROM user 
        WHERE user.spoken_language IN ({implode(',', $language_to_learn)})";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }
    public function findBySpokenLanguage($spokenLanguage): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.language_to_learn IN :value')
            ->setParameter('value', $spokenLanguage)
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[]
     */
    public function findByPatronage($patronage): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.is_godson = :val')
            ->orWhere('u.is_godparent = :val')
            ->setParameter('val', $patronage)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
