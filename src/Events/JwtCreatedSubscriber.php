<?php

namespace App\Events;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber
{
    // TODO: Read Documentation : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/2-data-customization.md

    // NOTE: Du côté JavaScript de notre application on aura une librairie qui permet de décoder les tokens et ainsi afficher ses infos dans l'interface

    public function updateJwtData(JWTCreatedEvent $event)
    {
        // 1. Récupérer le patient lié à l'utilisateur (pour avoir son firstName et son lastName)
        $user = $event->getUser();

        if ($user->getRoles()[0] === "ROLE_USER" && $user instanceof User) {
            $patient = $user->getPatient();

            // 2. Enrichir les data pour qu'elles contiennent ces données
            $data = $event->getData();
            $data['firstName'] = $patient->getFirstName();
            $data['lastName'] = $patient->getLastName();

            $event->setData($data);
        }
    }

}