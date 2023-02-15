<?php

namespace App\Entity;

use App\Repository\AssistantPsychologiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssistantPsychologiqueRepository::class)]
class AssistantPsychologique extends Personnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'id_assistant_psy', targetEntity: CreneauHoraire::class)]
    private Collection $creneauHoraires;

    #[ORM\OneToMany(mappedBy: 'id_assistant_psy', targetEntity: RendezVous::class)]
    private Collection $rendezVouses;

    public function __construct()
    {
        parent::__construct();
        $this->creneauHoraires = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CreneauHoraire>
     */
    public function getCreneauHoraires(): Collection
    {
        return $this->creneauHoraires;
    }

    public function addCreneauHoraire(CreneauHoraire $creneauHoraire): self
    {
        if (!$this->creneauHoraires->contains($creneauHoraire)) {
            $this->creneauHoraires->add($creneauHoraire);
            $creneauHoraire->setIdAssistantPsy($this);
        }

        return $this;
    }

    public function removeCreneauHoraire(CreneauHoraire $creneauHoraire): self
    {
        if ($this->creneauHoraires->removeElement($creneauHoraire)) {
            // set the owning side to null (unless already changed)
            if ($creneauHoraire->getIdAssistantPsy() === $this) {
                $creneauHoraire->setIdAssistantPsy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses->add($rendezVouse);
            $rendezVouse->setIdAssistantPsy($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getIdAssistantPsy() === $this) {
                $rendezVouse->setIdAssistantPsy(null);
            }
        }

        return $this;
    }
}
