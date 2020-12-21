<?php

namespace App\Entity;

use App\Repository\HistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryRepository::class)
 */
class History
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idFk;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $oldValue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $newValue;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entityClass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propertyName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFk(): ?int
    {
        return $this->idFk;
    }

    public function setIdFk(int $idFk): self
    {
        $this->idFk = $idFk;

        return $this;
    }

    public function getOldValue(): ?int
    {
        return $this->oldValue;
    }

    public function setOldValue(?int $oldValue): self
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    public function getNewValue(): ?int
    {
        return $this->newValue;
    }

    public function setNewValue(?int $newValue): self
    {
        $this->newValue = $newValue;

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

    public function getEntityClass(): ?string
    {
        return $this->entityClass;
    }

    public function setEntityClass(string $entityClass): self
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    public function setPropertyName(string $propertyName): self
    {
        $this->propertyName = $propertyName;

        return $this;
    }
}
