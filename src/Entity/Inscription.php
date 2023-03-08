<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $present = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?User $id_personnel = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Formation $id_formation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPresent(): ?bool
    {
        return $this->present;
    }

    public function setPresent(bool $present): self
    {
        $this->present = $present;

        return $this;
    }

    public function getIdPersonnel(): ?User
    {
        return $this->id_personnel;
    }

    public function setIdPersonnel(?User $id_personnel): self
    {
        $this->id_personnel = $id_personnel;

        return $this;
    }

    public function getIdFormation(): ?Formation
    {
        return $this->id_formation;
    }

    public function setIdFormation(?Formation $id_formation): self
    {
        $this->id_formation = $id_formation;

        return $this;
    }
}
