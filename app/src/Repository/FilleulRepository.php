<?php

namespace App\Repository;

use App\Entity\Filleul;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Filleul|null find($id, $lockMode = null, $lockVersion = null)
 * @method Filleul|null findOneBy(array $criteria, array $orderBy = null)
 * @method Filleul[]    findAll()
 * @method Filleul[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilleulRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filleul::class);
    }

    // /**
    //  * @return Filleul[] Returns an array of Filleul objects
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
    public function findOneBySomeField($value): ?Filleul
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
