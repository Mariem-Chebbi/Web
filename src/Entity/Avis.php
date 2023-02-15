<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Note = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?client $id_client = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?centre $id_centre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->Note;
    }

    public function setNote(int $Note): self
    {
        $this->Note = $Note;

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

    public function getIdCentre(): ?centre
    {
        return $this->id_centre;
    }

    public function setIdCentre(?centre $id_centre): self
    {
        $this->id_centre = $id_centre;

        return $this;
    }
}
