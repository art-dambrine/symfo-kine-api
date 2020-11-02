<?php

namespace App\Repository;

use App\Entity\Fce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fce[]    findAll()
 * @method Fce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fce::class);
    }

    // /**
    //  * @return Fce[] Returns an array of Fce objects
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
    public function findOneBySomeField($value): ?Fce
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
