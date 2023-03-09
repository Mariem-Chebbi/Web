<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("reservation_list")]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"veuillez saisir la quantite.")]
    #[Groups("reservation_list")]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"veuillez saisir une date.")]
    #[Assert\GreaterThanOrEqual("today", message:"La date saisie ne peut pas être antérieure à la date d'aujourd'hui.")]
    #[Groups("reservation_list")]
    private ?\DateTimeInterface $dateReservation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"veuillez choisir l'etat.")]
    #[Groups("reservation_list")]
    private ?string $etat = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'reservations',cascade: ['persist'])]
    #[Assert\NotBlank(message:"veuillez choisir des produits.")]
    #[Groups("reservation_list")]
    private Collection $idProduit;

    #[ORM\ManyToOne(inversedBy: 'reservations',cascade: ['persist'])]
    private ?User $user = null;

    
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
