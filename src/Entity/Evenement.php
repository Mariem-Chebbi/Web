<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"nom is required")]
    private ?string $nom_event = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"lieu is required")]
    private ?string $Lieu_event = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"description is required")]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"date is required")]
    private ?\DateTimeInterface $Date_debut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"date is required")]
    private ?\DateTimeInterface $Date_fin = null;

    #[ORM\OneToMany(mappedBy: 'evenement', targetEntity: Sponser::class)]
    #[Assert\NotBlank(message:"sponser is required")]
    private Collection $Sponser;

    public function __construct()
    {
        $this->Sponser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEvent(): ?string
    {
        return $this->nom_event;
    }

    public function setNomEvent(string $nom_event): self
    {
        $this->nom_event = $nom_event;

        return $this;
    }

    public function getLieuEvent(): ?string
    {
        return $this->Lieu_event;
    }

    public function setLieuEvent(string $Lieu_event): self
    {
        $this->Lieu_event = $Lieu_event;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->Date_debut;
    }

    public function setDateDebut(\DateTimeInterface $Date_debut): self
    {
        $this->Date_debut = $Date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->Date_fin;
    }

    public function setDateFin(\DateTimeInterface $Date_fin): self
    {
        $this->Date_fin = $Date_fin;

        return $this;
    }

    /**
     * @return Collection<int, Sponser>
     */
    public function getSponser(): Collection
    {
        return $this->Sponser;
    }

    public function addSponser(Sponser $sponser): self
    {
        if (!$this->Sponser->contains($sponser)) {
            $this->Sponser->add($sponser);
            $sponser->setEvenement($this);
        }

        return $this;
    }

    public function removeSponser(Sponser $sponser): self
    {
        if ($this->Sponser->removeElement($sponser)) {
            // set the owning side to null (unless already changed)
            if ($sponser->getEvenement() === $this) {
                $sponser->setEvenement(null);
            }
        }

        return $this;
    }
}
