<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Exceptions\PatientNotDefinedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Component\HttpKernel\Event\ViewEvent;

class UserPatientSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['setPatientForUser', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setPatientForUser(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($result instanceof User && $method === "POST") {

            // Si on essaye de creer un user classique (différent de "ROLE_ADMIN" ou "ROLE_KINE")

            if ($result->getRoles()[0] === "ROLE_USER") {

                if ($result->getPatient() === null) {
                    throw new PatientNotDefinedException(sprintf(
                        'The product patient is not defined while trying to create user with role "%s" (Hint: ajouter un patient via son uri d\'api dans le json)',
                        $result->getRoles()[0]
                    ));
                }

                // Recuperer le nom, prenom et date de naissance du patient afin de creer l'utilisateur
                $nom = $result->getPatient()->getLastName();
                $prenom = $result->getPatient()->getFirstName();
                $birthdate = $result->getPatient()->getBirthdate()->format('Y-m-d');

                $newUsername = strtolower($prenom) . '.' . strtolower($nom);

                // Assigner le username de l'utilisateur à partir de son prenom.nom et le password à partir de sa date de naissance
                $result->setUsername($newUsername);
                $result->setPassword($birthdate);
            }

        }

    }
}