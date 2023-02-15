<?php

namespace App\Entity;

use App\Repository\CreneauHoraireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreneauHoraireRepository::class)]
class CreneauHoraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $heure = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jour = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\ManyToOne(inversedBy: 'creneauHoraires')]
    private ?assistantPsychologique $id_assistant_psy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(?int $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(?string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdAssistantPsy(): ?assistantPsychologique
    {
        return $this->id_assistant_psy;
    }

    public function setIdAssistantPsy(?assistantPsychologique $id_assistant_psy): self
    {
        $this->id_assistant_psy = $id_assistant_psy;

        return $this;
    }
}
