<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Patient;
use App\Repository\PatientRepository;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManagerInterface;

class PatientUpdateCaracteristicSubscriber implements EventSubscriberInterface
{
    /**
     * @var PatientRepository
     * */
    private $patientRepository;

    /**
     * @var EntityManagerInterface
     * */
    private $entityManager;

    public function __construct(PatientRepository $patientRepository, EntityManagerInterface $entityManager)
    {
        $this->patientRepository = $patientRepository;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['updateHistoryUpdatePatient', EventPriorities::PRE_WRITE]
        ];
    }


    public function updateHistoryUpdatePatient(ViewEvent $event)
    {
        $patient = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($patient instanceof Patient && $method === "PATCH") {
            /* On travaille avec les elements suivants :
             * - poids = $patient->getPoids();
             * - fce = $patient->getFce();
             * - fevg = $patient->getFevg();
             * */

            $conn = $this->entityManager->getConnection();
            $sql = 'SELECT * FROM patient WHERE patient.id = :id';
            $patientBaseBeforeUpdate = [];

            try {
                $stmt = $conn->prepare($sql);
                $stmt->execute(array('id' => $patient->getId()));
                $patientBaseBeforeUpdate = $stmt->fetchAllAssociative();
            } catch (Exception $e) {
                $this->printErrorJson($e->getMessage());
            } catch (\Doctrine\DBAL\Exception $e) {
                $this->printErrorJson($e->getMessage());
            }

            // 1. recupération des elements taille, fce, fevg en base avant update
            $poidsOld = $patientBaseBeforeUpdate[0]["poids"];
            $fceOld = $patientBaseBeforeUpdate[0]["fce"];
            $fevgOld = $patientBaseBeforeUpdate[0]["fevg"];

            // TODO : comparer les différences sur les elements poids, fce, fevg
            // 2. comparaison des elements avec le contenu de la requête PATCH
            if ($poidsOld != $patient->getPoids()) {
                dd("Poids différent avec base", $poidsOld, $patient->getTaille());
                // TODO : faire la requête de sauvegarde dans la table historique
            }

            if ($fceOld != $patient->getFce()) {
                // dd("FCE différent avec base",$fceOld, $patient->getFce());
                // TODO : faire la requête de sauvegarde dans la table historique
            }

            if ($fevgOld != $patient->getFevg()) {
                // dd("FEVG différent avec base",$fevgOld, $patient->getFevg());
                // TODO : faire la requête de sauvegarde dans la table historique
            }

        }
    }


    public function printErrorJson($error)
    {
        // On envoie directement la reponse si erreur :
        $response = new Response(
            json_encode([
                'error' => $error,
            ]),
            Response::HTTP_INTERNAL_SERVER_ERROR,
            ['content-type' => 'application/json',
                'Access-Control-Allow-Origin' => '*']
        );
        $response->send();
        die;
    }
}