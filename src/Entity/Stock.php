<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Qte = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    private ?Produit $id_produit = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    private ?Centre $id_centre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->Qte;
    }

    public function setQte(int $Qte): self
    {
        $this->Qte = $Qte;

        return $this;
    }

    public function getIdProduit(): ?produit
    {
        return $this->id_produit;
    }

    public function setIdProduit(?produit $id_produit): self
    {
        $this->id_produit = $id_produit;

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
