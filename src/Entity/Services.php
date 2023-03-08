<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"libelle is required")]
    private ?string $Libelle = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"description is required")]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"icone is required")]
    private ?string $Icone = null;

    #[ORM\ManyToMany(targetEntity: Centre::class, mappedBy: 'idServices')]
    private Collection $centres;

    public function __construct()
    {
        $this->centres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

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

    public function getIcone(): ?string
    {
        return $this->Icone;
    }

    public function setIcone(string $Icone): self
    {
        $this->Icone = $Icone;

        return $this;
    }

    /**
     * @return Collection<int, Centre>
     */
    public function getCentres(): Collection
    {
        return $this->centres;
    }

    public function addCentre(Centre $centre): self
    {
        if (!$this->centres->contains($centre)) {
            $this->centres->add($centre);
            $centre->addIdService($this);
        }

        return $this;
    }

    public function removeCentre(Centre $centre): self
    {
        if ($this->centres->removeElement($centre)) {
            $centre->removeIdService($this);
        }

        return $this;
    }
}
