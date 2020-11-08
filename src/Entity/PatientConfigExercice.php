<?php

namespace App\Entity;

use App\Repository\PatientConfigExerciceRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PatientConfigExerciceRepository::class)
 * * @ApiResource(
 *     normalizationContext={
 *          "groups"={"config_exercices_read"}
 *     }
 * )
 */
class PatientConfigExercice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"config_exercices_read","patients_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"config_exercices_read","patients_read"})
     */
    private $OneRm;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"config_exercices_read","patients_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"config_exercices_read","patients_read"})
     */
    private $enabled;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="exercice")
     * @Groups({"config_exercices_read"})
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class, inversedBy="patientConfigExercices")
     * @Groups({"config_exercices_read","patients_read"})
     */
    private $exercice;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOneRm(): ?int
    {
        return $this->OneRm;
    }

    public function setOneRm(int $OneRm): self
    {
        $this->OneRm = $OneRm;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

}
