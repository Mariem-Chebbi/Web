<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_rdv = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?ListeAttente $id_liste_attente = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?User $id_personnel = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->date_rdv;
    }

    public function setDateRdv(?\DateTimeInterface $date_rdv): self
    {
        $this->date_rdv = $date_rdv;

        return $this;
    }

    public function getIdListeAttente(): ?listeAttente
    {
        return $this->id_liste_attente;
    }

    public function setIdListeAttente(?listeAttente $id_liste_attente): self
    {
        $this->id_liste_attente = $id_liste_attente;

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

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }
}
