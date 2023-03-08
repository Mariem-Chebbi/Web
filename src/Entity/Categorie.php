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
    #[Groups("categorie_list")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"libelle is required")]
    #[Groups("categorie_list")]
    private ?string $Libelle = null;

   /* #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Blog::class)]
    private Collection $blog;*/

    #[ORM\ManyToMany(targetEntity: Blog::class, mappedBy: 'Categorie',cascade: ['persist', 'remove'])]
    private Collection $blog;

    

    public function __construct()
    {
        $this->blog = new ArrayCollection();
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
    public function getBlog(): Collection
    {
        return $this->blog;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blog->contains($blog)) {
            $this->blog->add($blog);
            $blog->addCategorie($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blog->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getCategorie() === $this) {
                $blog->removeCategorie(null);
            }
        }

        return $this;
    }
}
