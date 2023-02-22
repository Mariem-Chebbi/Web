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
    private ?Formation $id_formation = null;

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
}
