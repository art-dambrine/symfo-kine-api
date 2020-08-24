<?php

namespace App\Repository;

use App\Entity\Exercice;
use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercice[]    findAll()
 * @method Exercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercice::class);
    }

    public function findLastChrono(Patient $patient) {
        return $this->createQueryBuilder("e")
                    ->select("e.chrono")
                    ->where("e.patient = :patient")
                    ->setParameter("patient", $patient)
                    ->orderBy("e.chrono", "DESC")
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function deleteExercicesByPatient(Patient $patient)
    {
        return $this->createQueryBuilder("e")
            ->delete("App\Entity\Exercice", "e")
            ->where("e.patient = :patient")
            ->setParameter("patient", $patient)
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return Exercice[] Returns an array of Exercice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Exercice
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
