<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

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
class Exercice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"exercices_read", "patients_read", "exercices_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"exercices_read", "patients_read", "exercices_subresource"})
     * @Assert\NotBlank(message="Le nom de l'exercice doit être renseigné")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"exercices_read", "patients_read", "exercices_subresource"})
     * @Assert\Type(type="numeric", message="Le nombre de repetition doit être un numérique")
     */
    private $numberOf;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="exercices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"exercices_read"})
     * @Assert\NotBlank(message="Le patient doit être renseigné")
     */
    private $patient;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"exercices_read", "patients_read"})
     * @Assert\NotBlank(message="Le chrono doit être renseigné")
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
