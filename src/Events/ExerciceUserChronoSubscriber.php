<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Exercice;
use App\Repository\ExerciceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Component\Security\Core\Security;

class ExerciceUserChronoSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var ExerciceRepository
     */
    private $repository;

    public function __construct(Security $security, ExerciceRepository $repository)
    {
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['setCurrentPatientAndChronoForExercice', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setCurrentPatientAndChronoForExercice(ViewEvent $event)
    {
        $exercice = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($exercice instanceof Exercice && $method === "POST") {

            // 1.a Trouver l'utilisateur actuellement connecté
            $user = $this->security->getUser();
            $patient = $user->getPatient();

            // 1.b Assigner l'utilisateur/patient à l'exercice créé
            $exercice->setPatient($patient);

            // 2.a J'ai besoin du Repository des exercices (ExerciceRepository)
            // 2.b Recupérer le dernier exercice qui a été inséré et récupérer son chrono
            $lastChrono = $this->repository->findLastChrono($patient);

            // 4. Dans ce nouvel exercice, on donne le dernier chrono + 1
            $exercice->setChrono($lastChrono + 1);

        }
    }

}