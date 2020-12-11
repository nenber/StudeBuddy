<?php

namespace App\Repository;

use App\Entity\Godson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Godson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Godson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Godson[]    findAll()
 * @method Godson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GodsonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Godson::class);
    }

    // /**
    //  * @return Godson[] Returns an array of Godson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Godson
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
