<?php

namespace App\Repository;

use App\Entity\PatientConfigExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PatientConfigExercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientConfigExercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientConfigExercice[]    findAll()
 * @method PatientConfigExercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientConfigExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientConfigExercice::class);
    }

    /**
     * @return PatientConfigExercice[] Returns an array of PatientConfigExercice objects
     */

    public function findListeExerciceByPatient($patientId)
    {
        return $this->createQueryBuilder('p')
            ->select('exe.id','exe.name')
            ->leftJoin('App\Entity\Exercice', 'exe', Join::WITH, 'p.exercice = exe.id')
            ->andWhere('p.patient = :patient')
            ->setParameter('patient', $patientId)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }




    // /**
    //  * @return PatientConfigExercice[] Returns an array of PatientConfigExercice objects
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
    public function findOneBySomeField($value): ?PatientConfigExercice
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
