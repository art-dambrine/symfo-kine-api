<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Exercice;
use App\Entity\Patient;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;

    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass)
    {
        // 1. Obtenir l'utilisateur connecté
        $user = $this->security->getUser();

        // Si on est dans le cas d'un utilisateur classique "ROLE_USER" on ne lui affichera que ses données personelles
        if ($user) {
            if ($user->getRoles()[0] === "ROLE_USER" && $user instanceof User) {

                $patientId = $user->getPatient()->getId();

                // 2. Si on demande des patients ou des exercices, agir sur la requête pour qu'elle tienne compte de l'utilisateur connecté
                if ($resourceClass === Patient::class || $resourceClass === Exercice::class) {
                    $rootAlias = $queryBuilder->getRootAliases()[0];

                    if ($resourceClass === Patient::class) {
                        $queryBuilder->andWhere("$rootAlias.id = :patientId");
                    } else if ($resourceClass === Exercice::class) {
                        $queryBuilder->andWhere("$rootAlias.patient = :patientId");
                    }
                    $queryBuilder->setParameter("patientId", $patientId);

                    // dd($queryBuilder);
                }
            }
        }
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        // TODO: Implement applyToCollection() method.
        $this->addWhere($queryBuilder, $resourceClass);

    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        // TODO: Implement applyToItem() method.
        $this->addWhere($queryBuilder, $resourceClass);
    }


}