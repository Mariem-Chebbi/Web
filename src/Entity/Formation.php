<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"libelle is required")]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"description is required")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"date is required")]
    private ?\DateTimeInterface $dateFormation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"image is required")]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'id_formation', targetEntity: Inscription::class)]
    private Collection $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateFormation(): ?\DateTimeInterface
    {
        return $this->dateFormation;
    }

    public function setDateFormation(\DateTimeInterface $dateFormation): self
    {
        $this->dateFormation = $dateFormation;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(User $user): ?Inscription
    {
        foreach ($this->inscriptions as $inscription) {
            if ($inscription->getIdPersonnel() === $user) {
                return $inscription;
            }
        }

        return null;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setIdFormation($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getIdFormation() === $this) {
                $inscription->setIdFormation(null);
            }
        }

        return $this;
    }

    public function isInscription(User $user): bool
    {
        foreach ($this->inscriptions as $inscription) {
            if ($inscription->getIdPersonnel() === $user) {
                return true;
            }
        }
    
        return false;
    }
}
