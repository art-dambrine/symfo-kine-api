<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"patients_read"}
 *     }
 * )
 */
class Patient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"patients_read", "exercices_read", "user_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"patients_read", "user_read"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"patients_read", "user_read"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     * @Groups({"patients_read", "user_read"})
     */
    private $birthdate;

    /**
     * @ORM\OneToMany(targetEntity=Exercice::class, mappedBy="patient")
     * @Groups({"patients_read"})
     */
    private $exercices;

    public function __construct()
    {
        $this->exercices = new ArrayCollection();
    }

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Collection|Exercice[]
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
            $exercice->setPatient($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): self
    {
        if ($this->exercices->contains($exercice)) {
            $this->exercices->removeElement($exercice);
            // set the owning side to null (unless already changed)
            if ($exercice->getPatient() === $this) {
                $exercice->setPatient(null);
            }
        }

        return $this;
    }
}
