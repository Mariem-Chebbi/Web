<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"libelle is required")]
    private ?string $Libelle = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Blog::class)]
    private Collection $idBlog;

    public function __construct()
    {
        $this->idBlog = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    /**
     * @return Collection<int, Blog>
     */
    public function getIdBlog(): Collection
    {
        return $this->idBlog;
    }

    public function addIdBlog(Blog $idBlog): self
    {
        if (!$this->idBlog->contains($idBlog)) {
            $this->idBlog->add($idBlog);
            $idBlog->setCategorie($this);
        }

        return $this;
    }

    public function removeIdBlog(Blog $idBlog): self
    {
        if ($this->idBlog->removeElement($idBlog)) {
            // set the owning side to null (unless already changed)
            if ($idBlog->getCategorie() === $this) {
                $idBlog->setCategorie(null);
            }
        }

        return $this;
    }
}
