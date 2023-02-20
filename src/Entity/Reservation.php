<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"quantite is required")]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"date is required")]
    private ?\DateTimeInterface $dateReservation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"etat is required")]
    private ?string $etat = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'reservations',cascade: ['persist'])]
    #[Assert\NotBlank(message:"produit is required")]
    private Collection $idProduit;

    
    public function __construct()
    {
        $this->idProduit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(?\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getIdProduit(): Collection
    {
        return $this->idProduit;
    }

    public function addIdProduit(Product $idProduit): self
    {
        if (!$this->idProduit->contains($idProduit)) {
            $this->idProduit->add($idProduit);
        }

        return $this;
    }

    public function removeIdProduit(Product $idProduit): self
    {
        $this->idProduit->removeElement($idProduit);

        return $this;
    }
}
