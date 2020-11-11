<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Patient;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PatientUpdateDateSubscriber implements EventSubscriberInterface
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * L'encodeur de mot de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;


    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;

    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['updateUserBeforePatient', EventPriorities::PRE_WRITE]
        ];
    }

    public function updateUserBeforePatient(ViewEvent $event){
        $patient = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($patient instanceof Patient && $method === "PATCH") {
            $user = $this->userRepository->findOneBy(['patient' => $patient->getId()]);
            $hash = $this->encoder->encodePassword($user, $patient->getBirthdate()->format('Y-m-d'));
            $user->setPassword($hash);
        }
    }

}