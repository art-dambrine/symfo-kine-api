<?php

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
 *     normalizationContext={
 *           "groups"={"exercices_read"}
 *     }
 * )
 */
class Exercice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"exercices_read", "patients_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"exercices_read", "patients_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"exercices_read", "patients_read"})
     */
    private $numberOf;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="exercices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"exercices_read"})
     */
    private $patient;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"exercices_read", "patients_read"})
     *
     */
    private $chrono;

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

    public function getNumberOf(): ?int
    {
        return $this->numberOf;
    }

    public function setNumberOf(int $numberOf): self
    {
        $this->numberOf = $numberOf;

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

    public function getChrono(): ?int
    {
        return $this->chrono;
    }

    public function setChrono(int $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }
}
