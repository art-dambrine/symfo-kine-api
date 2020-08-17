<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Entity\Patient;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * L'encodeur de mot de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');


        for ($i = 0; $i < 10; $i++) {
            $patient = new Patient();

            $chrono = 1;

            $patient->setFirstName($faker->firstName())
                ->setLastName($faker->lastName)
                ->setBirthdate($faker->dateTimeBetween('-30 years', '-15 years'));

            $user = new User();
            $user->setUsername(strtolower(substr($patient->getFirstName(), 0, 1)) . '.' . strtolower($patient->getLastName()))
                ->setPatient($patient)
                ->setPassword($this->encoder->encodePassword($user, $patient->getBirthdate()->format('Y-m-d')));  // format mot de passe 2002-07-21

            $manager->persist($patient);
            $manager->persist($user);

            for ($c = 0; $c < mt_rand(2, 4); $c++) {
                $exercice = new Exercice();
                $exercice->setName(strtoupper($faker->randomLetter))
                    ->setNumberOf($faker->numberBetween(5, 20))
                    ->setPatient($patient)
                    ->setChrono($chrono);

                $chrono++;

                $manager->persist($exercice);
            }
        }


        $manager->flush();
    }
}
