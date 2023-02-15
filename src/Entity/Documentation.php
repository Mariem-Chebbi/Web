<?php

namespace App\Entity;

use App\Repository\DocumentationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentationRepository::class)]
class Documentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;

    #[ORM\ManyToOne(inversedBy: 'documentations')]
    private ?SuperAdministrateur $id_super_admin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getIdSuperAdmin(): ?SuperAdministrateur
    {
        return $this->id_super_admin;
    }

    public function setIdSuperAdmin(?SuperAdministrateur $id_super_admin): self
    {
        $this->id_super_admin = $id_super_admin;

        return $this;
    }
}
