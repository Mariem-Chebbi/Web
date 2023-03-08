<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"libelle is required")]
    #[Groups("blog_list")]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"description is required")]
    #[Groups("blog_list")]    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"date is required")]
    #[Assert\LessThanOrEqual("today", message:"La date saisie ne peut pas être superieur à la date d'aujourd'hui.")]
    #[Groups("blog_list")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"auteur is required")]
    #[Groups("blog_list")]
    private ?string $auteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"image is required")]
    #[Assert\Image(maxSize:"10M",
        maxSizeMessage:"image is too large",
        mimeTypesMessage:"invalid file type",
        uploadErrorMessage:"the file could not be uploaded")]
    #[Groups("blog_list")]
    private ?string $image = null;

   /* #[ORM\ManyToOne(inversedBy: 'idBlog',cascade: ['persist', 'remove'])]
    private ?Categorie $categorie = null;*/

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'blog',cascade: ['persist'])]
    #[Assert\NotBlank(message:"categorie is required")]
    private Collection $Categorie;

    #[ORM\OneToMany(mappedBy: 'blog', targetEntity: CommentBlog::class)]
    private Collection $commentBlogs;

    


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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

   /**
     * @return Collection<int, Categorie>
     */
    
    public function __construct()
    {
        $this->Categorie = new ArrayCollection();
        $this->commentBlogs = new ArrayCollection();
    }

    public function getCategorie(): Collection
    {
        return $this->Categorie;
    }

    // public function setIdCategorie(int $idCategorie): self
    // {
    //     $this->idCategorie = $idCategorie;

    //     return $this;
    // }

    public function addCategorie(Categorie $Categorie): self
    {
        if (!$this->Categorie->contains($Categorie)) {
            $this->Categorie->add($Categorie);
        }

        return $this;
    }

    public function removeCategorie(Categorie $Categorie): self
    {
        $this->Categorie->removeElement($Categorie);

        return $this;
    }

    /**
     * @return Collection<int, CommentBlog>
     */
    public function getCommentBlogs(): Collection
    {
        return $this->commentBlogs;
    }

    public function addCommentBlog(CommentBlog $commentBlog): self
    {
        if (!$this->commentBlogs->contains($commentBlog)) {
            $this->commentBlogs->add($commentBlog);
            $commentBlog->setBlog($this);
        }

        return $this;
    }

    public function removeCommentBlog(CommentBlog $commentBlog): self
    {
        if ($this->commentBlogs->removeElement($commentBlog)) {
            // set the owning side to null (unless already changed)
            if ($commentBlog->getBlog() === $this) {
                $commentBlog->setBlog(null);
            }
        }

        return $this;
    }
}
