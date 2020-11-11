<?php


namespace App\Controller;

use App\Entity\Patient;
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
        // TODO: Faire le joli algo de création des configs d'exercices.

        $patientId = $data->getId();
        $listeTypesExercices = $this->exerciceRepository->findAll();
        $listeConfigsDuPatient = $this->patientConfigExerciceRepository->findListeExerciceByPatient($patientId);

        $tmp = [];
        foreach ($listeTypesExercices as $exercice){
            // Récupérer la liste des config_exercice du patient
            array_push($tmp,[
                "id" => $exercice->getId(),
                "name" => $exercice->getName()
            ]);
        }
        $listeTypesExercices = $tmp;

        dd($listeTypesExercices);

        return $data;
    }


}