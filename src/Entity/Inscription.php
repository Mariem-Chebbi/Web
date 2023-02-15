<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_inscription = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?formation $id_formation = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?personnel $id_personnel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->Date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $Date_inscription): self
    {
        $this->Date_inscription = $Date_inscription;

        return $this;
    }

    public function getIdFormation(): ?formation
    {
        return $this->id_formation;
    }

    public function setIdFormation(?formation $id_formation): self
    {
        $this->id_formation = $id_formation;

        return $this;
    }

    public function getIdPersonnel(): ?personnel
    {
        return $this->id_personnel;
    }

    public function setIdPersonnel(?personnel $id_personnel): self
    {
        $this->id_personnel = $id_personnel;

        return $this;
    }
}
