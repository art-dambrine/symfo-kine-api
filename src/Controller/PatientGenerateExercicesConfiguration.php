<?php


namespace App\Controller;

use App\Entity\Patient;
use App\Entity\PatientConfigExercice;
use App\Repository\ExerciceRepository;
use App\Repository\PatientConfigExerciceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PatientGenerateExercicesConfiguration extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ExerciceRepository
     */
    private $exerciceRepository;

    private $patientConfigExerciceRepository;

    public function __construct(ObjectManager $manager, ExerciceRepository $exerciceRepository, PatientConfigExerciceRepository $patientConfigExerciceRepository)
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

        // 3. Recuperation de la liste des exercices du patient
        $listeConfigsDuPatient = $this->patientConfigExerciceRepository->findListeExerciceByPatient($patientId);

            // dd("listeConfigsDuPatient : ", $listeConfigsDuPatient, "listeTypesExercices : ", $listeTypesExercices);

        // 4. Reperage des exercices de base n'etant pas présent dans la config du patient
        // TODO : Corriger le bug lorsque la liste config du patient est nulle
        foreach ($listeTypesExercices as $aV) $aTmp1[] = $aV['id'];
        foreach ($listeConfigsDuPatient as $aV) $aTmp2[] = $aV['id'];
        $result = array_diff($aTmp1, $aTmp2);

        foreach ($result as $value) $listeIdExerciceToAdd[] = $value;

        // 5. Ajouter la liste d'exercices à la config du patient
        foreach ($listeIdExerciceToAdd as $idExercice){

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