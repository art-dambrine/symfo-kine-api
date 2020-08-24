<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Patient;
use App\Repository\ExerciceRepository;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PatientDeleteSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ExerciceRepository
     */
    private $exerciceRepository;

    public function __construct(UserRepository $userRepository, ExerciceRepository $exerciceRepository)
    {
        $this->userRepository = $userRepository;
        $this->exerciceRepository = $exerciceRepository;
    }


    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['deleteUserBeforePatient', EventPriorities::PRE_WRITE]
        ];
    }

    public function deleteUserBeforePatient(ViewEvent $event){
        $patient = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($patient instanceof Patient && $method === "DELETE") {
            $this->userRepository->deleteUserByPatient($patient);
            $this->exerciceRepository->deleteExercicesByPatient($patient);
        }
    }

}