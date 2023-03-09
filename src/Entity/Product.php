<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Stof\DoctrineExtensionsBundle\Mapping\Annotation as Stof;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("product_list")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"veuillez saisir un libelle.")]
    #[Groups("product_list")]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"veuillez saisir une description.")]
    #[Groups("product_list")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"veuillez choisir une image.")]
    #[Assert\Image(maxSize:"10M",
        maxSizeMessage:"image is too large. max size 10M.",
        mimeTypesMessage:"invalid file type. allowed types are .jpg ou .png .jpeg .",
        uploadErrorMessage:"the file could not be uploaded.")]
    #[Groups("product_list")]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Reservation::class, mappedBy: 'idProduit',cascade: ['persist', 'remove'])]
    #[Groups("product_list")]
    private Collection $reservations;

    #[ORM\Column]
    #[Assert\NotBlank(message:"veuillez saisir la quantite.")]
    #[Groups("product_list")]
    private ?int $quantite = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Favorite::class,cascade: ['persist', 'remove'])]
    private Collection $favorites;

    #[ORM\ManyToOne(inversedBy: 'produit')]
    private ?Raiting $raiting = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->addIdProduit($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeIdProduit($this);
        }

        return $this;
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

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorite(User $user): ?Favorite
{
    foreach ($this->favorites as $favorite) {
        if ($favorite->getUser() === $user) {
            return $favorite;
        }
    }

    return null;
}

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setProduct($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getProduct() === $this) {
                $favorite->setProduct(null);
            }
        }

        return $this;
    }

    public function isFavorite(User $user): bool
{
    foreach ($this->favorites as $favorite) {
        if ($favorite->getUser() === $user) {
            return true;
        }
    }

    return false;
}

    public function getRaiting(): ?Raiting
    {
        return $this->raiting;
    }

    public function setRaiting(?Raiting $raiting): self
    {
        $this->raiting = $raiting;

        return $this;
    }
}
