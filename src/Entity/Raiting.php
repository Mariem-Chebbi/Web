<?php

namespace App\Entity;

use App\Repository\RaitingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaitingRepository::class)]
class Raiting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'raitings')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'raitings')]
    private ?User $user = null;

    #[ORM\Column]
    private ?int $raiting = null;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRaiting(): ?int
    {
        return $this->raiting;
    }

    public function setRaiting(int $raiting): self
    {
        $this->raiting = $raiting;

        return $this;
    }
}
