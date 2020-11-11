<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 * @ApiResource(
 *     subresourceOperations={
 *          "exercices_get_subresource"={"path"="/patients/{id}/exercices"}
 *     },
 *     itemOperations={"GET","PUT","DELETE","PATCH", "generateexercicesconfig"={
 *          "method"="POST",
 *          "path"="/exercices/{id}/generateexercicesconfig",
 *          "controller"="App\Controller\PatientGenerateExercicesConfiguration",
 *          "openapi_context"={
 *          "summary"="Genere la config des exercices du patient",
 *              "description"="Genere la config des exercices par defaut du patient et renvoie un tableau JSON"
 *           }
 *         }
 *     },
 *     normalizationContext={
 *          "groups"={"patients_read"}
 *     },
 *     denormalizationContext={"disable_type_enforcement"=false}
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
     * @Assert\NotBlank(message="Le prenom est obligatoire")
     * @Assert\Length(min=3, minMessage="Le prenom doit faire entre 3 et 255 char" , max="255", maxMessage="Le prenom doit faire entre 3 et 255 char")
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
     * @Assert\NotBlank(message="La date de naissance doit être renseignée")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"patients_read"})
     */
    private $borg;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"patients_read"})
     * @Groups({"patients_read"})
     */
    private $taille;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"patients_read"})
     */
    private $poids;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"patients_read"})
     */
    private $bbloquant;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"patients_read"})
     */
    private $dnd;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"patients_read"})
     */
    private $did;

    /**
     * @ORM\OneToMany(targetEntity=Fce::class, mappedBy="patient")
     * @Groups({"patients_read"})
     */
    private $fces;

    /**
     * @ORM\OneToMany(targetEntity=Fevg::class, mappedBy="patient")
     * @Groups({"patients_read"})
     */
    private $fevgs;

    /**
     * @ORM\OneToMany(targetEntity=PatientConfigExercice::class, mappedBy="patient")
     * @Groups({"patients_read"})
     */
    private $exercice;


    public function __construct()
    {
        $this->fces = new ArrayCollection();
        $this->fevgs = new ArrayCollection();
        $this->exercice = new ArrayCollection();
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

    public function getBorg(): ?bool
    {
        return $this->borg;
    }

    public function setBorg(bool $borg): self
    {
        $this->borg = $borg;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(?int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(?int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getBbloquant(): ?bool
    {
        return $this->bbloquant;
    }

    public function setBbloquant(bool $bbloquant): self
    {
        $this->bbloquant = $bbloquant;

        return $this;
    }

    public function getDnd(): ?bool
    {
        return $this->dnd;
    }

    public function setDnd(bool $dnd): self
    {
        $this->dnd = $dnd;

        return $this;
    }

    public function getDid(): ?bool
    {
        return $this->did;
    }

    public function setDid(bool $did): self
    {
        $this->did = $did;

        return $this;
    }

    /**
     * @return Collection|Fce[]
     */
    public function getFces(): Collection
    {
        return $this->fces;
    }

    public function addFce(Fce $fce): self
    {
        if (!$this->fces->contains($fce)) {
            $this->fces[] = $fce;
            $fce->setPatient($this);
        }

        return $this;
    }

    public function removeFce(Fce $fce): self
    {
        if ($this->fces->contains($fce)) {
            $this->fces->removeElement($fce);
            // set the owning side to null (unless already changed)
            if ($fce->getPatient() === $this) {
                $fce->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Fevg[]
     */
    public function getFevgs(): Collection
    {
        return $this->fevgs;
    }

    public function addFevg(Fevg $fevg): self
    {
        if (!$this->fevgs->contains($fevg)) {
            $this->fevgs[] = $fevg;
            $fevg->setPatient($this);
        }

        return $this;
    }

    public function removeFevg(Fevg $fevg): self
    {
        if ($this->fevgs->contains($fevg)) {
            $this->fevgs->removeElement($fevg);
            // set the owning side to null (unless already changed)
            if ($fevg->getPatient() === $this) {
                $fevg->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PatientConfigExercice[]
     */
    public function getExercice(): Collection
    {
        return $this->exercice;
    }

    public function addExercice(PatientConfigExercice $exercice): self
    {
        if (!$this->exercice->contains($exercice)) {
            $this->exercice[] = $exercice;
            $exercice->setPatient($this);
        }

        return $this;
    }

    public function removeExercice(PatientConfigExercice $exercice): self
    {
        if ($this->exercice->contains($exercice)) {
            $this->exercice->removeElement($exercice);
            // set the owning side to null (unless already changed)
            if ($exercice->getPatient() === $this) {
                $exercice->setPatient(null);
            }
        }

        return $this;
    }

}
