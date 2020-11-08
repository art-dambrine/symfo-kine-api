<?php

namespace App\Entity;

use App\Repository\FceRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FceRepository::class)
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"fce_read"}
 *     }
 * )
 */
class Fce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"patients_read", "fce_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"patients_read", "fce_read"})
     */
    private $fce;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"patients_read", "fce_read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="fces")
     * @Groups({"fce_read"})
     */
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFce(): ?int
    {
        return $this->fce;
    }

    public function setFce(int $fce): self
    {
        $this->fce = $fce;

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

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
