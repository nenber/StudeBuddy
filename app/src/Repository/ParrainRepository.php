<?php

namespace App\Repository;

use App\Entity\Parrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Parrain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parrain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parrain[]    findAll()
 * @method Parrain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parrain::class);
    }

    // /**
    //  * @return Parrain[] Returns an array of Parrain objects
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
    public function findOneBySomeField($value): ?Parrain
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
