<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 * @ApiResource()
 */
class Exercice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=PatientConfigExercice::class, mappedBy="exercice")
     */
    private $patientConfigExercices;

    public function __construct()
    {
        $this->patientConfigExercices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|PatientConfigExercice[]
     */
    public function getPatientConfigExercices(): Collection
    {
        return $this->patientConfigExercices;
    }

    public function addPatientConfigExercice(PatientConfigExercice $patientConfigExercice): self
    {
        if (!$this->patientConfigExercices->contains($patientConfigExercice)) {
            $this->patientConfigExercices[] = $patientConfigExercice;
            $patientConfigExercice->setExercice($this);
        }

        return $this;
    }

    public function removePatientConfigExercice(PatientConfigExercice $patientConfigExercice): self
    {
        if ($this->patientConfigExercices->contains($patientConfigExercice)) {
            $this->patientConfigExercices->removeElement($patientConfigExercice);
            // set the owning side to null (unless already changed)
            if ($patientConfigExercice->getExercice() === $this) {
                $patientConfigExercice->setExercice(null);
            }
        }

        return $this;
    }
}
