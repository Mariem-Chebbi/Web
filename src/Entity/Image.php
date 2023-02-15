<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Url = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?centre $Id_centre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->Url;
    }

    public function setUrl(?string $Url): self
    {
        $this->Url = $Url;

        return $this;
    }

    public function getIdCentre(): ?centre
    {
        return $this->Id_centre;
    }

    public function setIdCentre(?centre $Id_centre): self
    {
        $this->Id_centre = $Id_centre;

        return $this;
    }
}
