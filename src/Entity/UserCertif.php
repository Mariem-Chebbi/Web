<?php

namespace App\Entity;

use App\Repository\UserCertifRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCertifRepository::class)]
class UserCertif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userCertifs')]
    private ?User $id_personnel = null;

    #[ORM\ManyToOne(inversedBy: 'userCertifs')]
    private ?Certification $id_certif = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdCertif(): ?Certification
    {
        return $this->id_certif;
    }

    public function setIdCertif(?Certification $id_certif): self
    {
        $this->id_certif = $id_certif;

        return $this;
    }
}
