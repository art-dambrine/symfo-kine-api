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