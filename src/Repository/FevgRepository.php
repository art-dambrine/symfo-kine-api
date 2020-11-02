<?php

namespace App\Repository;

use App\Entity\Fevg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fevg|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fevg|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fevg[]    findAll()
 * @method Fevg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FevgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fevg::class);
    }

    // /**
    //  * @return Fevg[] Returns an array of Fevg objects
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
    public function findOneBySomeField($value): ?Fevg
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
