<?php


namespace App\Controller;

use App\Entity\Patient;
use App\Entity\PatientConfigExercice;
use App\Repository\ExerciceRepository;
use App\Repository\PatientConfigExerciceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PatientGenerateExercicesConfiguration extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var ExerciceRepository
     */
    private $exerciceRepository;

    private $patientConfigExerciceRepository;

    public function __construct(EntityManagerInterface $manager, ExerciceRepository $exerciceRepository, PatientConfigExerciceRepository $patientConfigExerciceRepository)
    {
        $this->manager = $manager;
        $this->exerciceRepository = $exerciceRepository;
        $this->patientConfigExerciceRepository = $patientConfigExerciceRepository;
    }

    public function __invoke(Patient $data)
    {
        $patient = $data;

        // 1. Recuperation de l'ID du patient
        $patientId = $patient->getId();

        // 2. Recuperation de la liste d'exercices de base
        $listeTypesExercices = $this->exerciceRepository->findAll();
        $tmp = [];
        foreach ($listeTypesExercices as $exercice)
            array_push($tmp, ["id" => $exercice->getId(), "name" => $exercice->getName()]);
        $listeTypesExercices = $tmp;

        // 3. Recuperation de la liste des exercices du patient avant l'update
        $listeConfigsDuPatient = $this->patientConfigExerciceRepository->findListeExerciceByPatient($patientId);


        // 4. Repérage des exercices de base n'étant pas présents dans la config du patient
        $aTmp1 = $aTmp2 = [];
        foreach ($listeTypesExercices as $aV) $aTmp1[] = $aV['id'];
        foreach ($listeConfigsDuPatient as $aV) $aTmp2[] = $aV['id'];
        $listeIdExerciceToAdd = array_diff($aTmp1, $aTmp2);

        // 5. Ajouter la liste d'exercices à la config du patient
        if(!empty($listeIdExerciceToAdd))
            foreach ($listeIdExerciceToAdd as $idExercice) {

                $configExercice = new PatientConfigExercice();
                $configExercice->setPatient($patient);
                $configExercice->setExercice($this->exerciceRepository->find($idExercice));
                $configExercice->setOneRm(0);
                $configExercice->setCreatedAt(new \DateTime());
                $configExercice->setEnabled(1);

                $this->manager->persist($configExercice);

                $patient->addExercice($configExercice);
            }

        return $data;
    }


}