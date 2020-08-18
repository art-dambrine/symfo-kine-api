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