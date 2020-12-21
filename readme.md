# Environnement de dev

## Si nouveau projet
### Installation symfony
```
$ symfony check:requirements
```
### Composer
```
$ composer create-project symfony/skeleton kine_api_project
```
### Run server localhost
```
$ symfony server:start --port=80
```
## A partir du projet existant
```
$ cd projects/

$ git clone ...

$ cd my-project/

$ composer install
```
### Dev dependencies
```
$ composer require orm-fixtures fzaninotto/faker --dev
 ```
# Etapes du developpement de l'application

NOTE: Souvent en phase de dev pensez à vider le cache de votre application Symfony (cela vous evitera de chercher pour des erreurs qui n'existent pas)
```
php bin/console cache:clear
```

## Etape 1 : Creation des entites symfony

$ php bin/console make:entity

- Creation de l'entite Patient
- Creation de l'entite Exercice (relation ManyToOne avec Patient)

NOTE: ne pas oublier de faire les migrations doctrine
```
$ php bin/console make:migration

$ php bin/console doctrine:migrations:migrate
```
## Etape 2 : Fixtures (./src/DataFixtures)
```
$ php bin/console doctrine:fixtures:load
```
## Etape 3 : Les utilisateurs
```
$ php bin/console make:user

$ php bin/console make:entity User
```
(ajout d'une relation OneToOne entre User et Patient)

# Astuces de dev

## Les champs calculés avec les groupes de serialisation
```
    /**
     * Recupère le nombre total de repetitions à réaliser par le patient
     * @Groups({"patients_read"})
     * @return int
     */
    public function getTotalRepetition(): int
    {
        return array_reduce($this->exercices->toArray(), function ($total, $exercice) {
            return $total + $exercice->getNumberOf();
        }, 0);
    }
``` 

## Créer ses propres opérations (custom controller)

```
<?php

namespace App\Controller;

use App\Entity\Exercice;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExerciceIncrementationController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(Exercice $data)
    {
        // TODO: Implement __invoke() method.
        $data->setChrono($data->getChrono() + 1);

        $this->manager->flush();

        return $data;
    }
}
```

NOTE: Si erreur symfony par rapport au 'ObjectManager' ajouter `Doctrine\Common\Persistence\ObjectManager: '@doctrine.orm.default_entity_manager'` au config/services.yaml


Ajout d'une operation custom au niveau de itemOperations, ici c'est l'operation 'increment' :

```
<?php

// App/src/entity/Exercice.php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 * @ApiResource(
 *     attributes={
 *          "pagination_enabled"=true
 *     },
 *     subresourceOperations={
 *           "api_patients_exercices_get_subresource"={
 *                  "normalization_context"={"groups"={"exercices_subresource"}}
 *            }
 *     },
 *     itemOperations={"GET","PUT","DELETE","PATCH", "increment"={
 *          "method"="POST",
 *          "path"="/exercices/{id}/increment",
 *          "controller"="App\Controller\ExerciceIncrementationController",
 *          "openapi_context"={
                "summary"="Incremente un exercice",
 *              "description"="Incremente le chrono d'un exercice donnée"
 *           }
 *         }
 *     },
 *     normalizationContext={
 *           "groups"={"exercices_read"}
 *     }
 * )
 */
``` 

## Validation des données

https://symfony.com/doc/current/reference/constraints/NotBlank.html

# Authentification JWT

````
composer require "lexik/jwt-authentication-bundle"
````

Generate keys
````
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096 # (1)
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem # (2)
````

This will ask you for the JWT_PASSPHRASE
Will confirm the JWT_PASSPHRASE again

Give read rights on generated key
````
cd config/jwt
sudo chmod 640 private.pem
sudo chown user:www-data private.pem
````
Follow the jwt guide on Github LexikJWTAuth @ GitHub

# Installation de VueJS avec Symfony

```
$ composer req encore

$ npm install

$ npm install -D vue vue-loader vue-template-compiler

$ npm install bootstrap bootstrap-vue
$ npm install dotenv
```

## Lancer le serveur de dev

```
$ npm run dev-server
```

## Compiler pour la prod

```
$ npm run build
```


# Notes sur le developpement

Historisation des données patient et 1RM inspirée de https://github.com/XSiraudin/doctrine-orm-history-bundle
