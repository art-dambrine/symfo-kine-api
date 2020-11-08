<?php

namespace App\Entity;

use App\Repository\FevgRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FevgRepository::class)
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"fevg_read"}
 *     }
 * )
 */
class Fevg
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"patients_read", "fevg_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"patients_read", "fevg_read"})
     */
    private $fevg;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"patients_read", "fevg_read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="fevgs")
     * @Groups({"fevg_read"})
     */
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFevg(): ?int
    {
        return $this->fevg;
    }

    public function setFevg(int $fevg): self
    {
        $this->fevg = $fevg;

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
