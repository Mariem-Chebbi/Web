<?php

namespace App\Entity;

use App\Repository\CreneauHoraireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PhpParser\ErrorHandler\Collecting;


#[ORM\Entity(repositoryClass: CreneauHoraireRepository::class)]
class CreneauHoraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\LessThan(
        message: "L'heure début doit être inférieur à l'heure fin",
        propertyPath: 'heure_fin',
    )]
    private ?int $heure_debut = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "Veuillez choisir un jour")]
    private ?string $jour = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column(nullable: true)]
    private ?int $heure_fin = null;

    //#[ORM\ManyToOne(inversedBy: 'creneauHoraires')]
    //private ?AssistantPsychologique $id_assistant_psy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDebut(): ?int
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(?int $heure): self
    {
        $this->heure_debut = $heure;

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

    // public function getIdAssistantPsy(): ?assistantPsychologique
    // {
    //     return $this->id_assistant_psy;
    // }

    // public function setIdAssistantPsy(?assistantPsychologique $id_assistant_psy): self
    // {
    //     $this->id_assistant_psy = $id_assistant_psy;

    //     return $this;
    // } 

    public function getHeureFin(): ?int
    {
        return $this->heure_fin;
    }

    public function setHeureFin(int $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }
}
