<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nom_sponsor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Logo_sponsor = null;

    #[ORM\ManyToOne(inversedBy: 'sponsors')]
    private ?evenement $id_event = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSponsor(): ?string
    {
        return $this->Nom_sponsor;
    }

    public function setNomSponsor(?string $Nom_sponsor): self
    {
        $this->Nom_sponsor = $Nom_sponsor;

        return $this;
    }

    public function getLogoSponsor(): ?string
    {
        return $this->Logo_sponsor;
    }

    public function setLogoSponsor(?string $Logo_sponsor): self
    {
        $this->Logo_sponsor = $Logo_sponsor;

        return $this;
    }

    public function getIdEvent(): ?evenement
    {
        return $this->id_event;
    }

    public function setIdEvent(?evenement $id_event): self
    {
        $this->id_event = $id_event;

        return $this;
    }
}
