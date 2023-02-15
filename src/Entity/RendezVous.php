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
    private ?client $id_client = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?assistantPsychologique $id_assistant_psy = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?listeAttente $id_liste_attente = null;

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

    public function getIdClient(): ?client
    {
        return $this->id_client;
    }

    public function setIdClient(?client $id_client): self
    {
        $this->id_client = $id_client;

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

    public function getIdListeAttente(): ?listeAttente
    {
        return $this->id_liste_attente;
    }

    public function setIdListeAttente(?listeAttente $id_liste_attente): self
    {
        $this->id_liste_attente = $id_liste_attente;

        return $this;
    }
}
