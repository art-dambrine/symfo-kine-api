<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Fce;
use App\Entity\Fevg;
use App\Entity\PatientConfigExercice;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DefaultDateSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['addDefaultDate', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function addDefaultDate(ViewEvent $event){
        $data = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (($data instanceof Fce || $data instanceof Fevg || $data instanceof PatientConfigExercice)  && $method === "POST") {
            // Si createdAt est null on met la date actuelle :
            if($data->getCreatedAt() == null)
                $data->setCreatedAt(new \DateTime());
        }
    }

}