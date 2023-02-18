<?php

namespace App\Entity;

use App\Repository\CreneauHoraireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CreneauHoraireRepository::class)]
class CreneauHoraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"heure debut is required")]
    private ?int $heure_debut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"jour is required")]
    private ?string $jour = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"etat is required")]
    private ?bool $etat = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"heure fin is required")]
    private ?int $heure_fin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDebut(): ?int
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(int $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

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
