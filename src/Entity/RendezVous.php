<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['rendezvous:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\GreaterThan('today', message: 'Veuillez choisir une date valide')]
    #[Groups(['rendezvous:read'])]
    private ?\DateTimeInterface $date_rdv = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?ListeAttente $id_liste_attente = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses', cascade: ["persist"])]
    #[Assert\NotNull(message: "Veuillez choisir un personnel")]
    private ?User $id_personnel = null;

    #[ORM\Column(nullable: true)]
    // #[Assert\NotBlank(message: "Le personnel n'est pas disponible, veuillez choisir une autre date")]
    // #[Assert\NotNull(message: "Veuillez choisir une heure")]
    #[Groups(['rendezvous:read'])]
    private ?int $heure = null;

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

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(?int $heure): self
    {
        $this->heure = $heure;

        return $this;
    }
}
