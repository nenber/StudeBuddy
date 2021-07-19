<?php

namespace App\Repository;

use App\Entity\Godparent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Godparent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Godparent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Godparent[]    findAll()
 * @method Godparent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GodparentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Godparent::class);
    }

    // /**
    //  * @return Godparent[] Returns an array of Godparent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Godparent
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
