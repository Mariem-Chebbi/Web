<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $num_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Favorite::class,cascade: ['persist', 'remove'])]
    private Collection $favorites;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reservation::class,cascade: ['persist', 'remove'])]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'id_personnel', targetEntity: Inscription::class,cascade: ['persist', 'remove'])]
    private Collection $inscriptions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Raiting::class,cascade: ['persist', 'remove'])]
    private Collection $raitings;

    #[ORM\OneToMany(mappedBy: 'id_personnel', targetEntity: UserCertif::class,cascade: ['persist', 'remove'])]
    private Collection $userCertifs;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CommentBlog::class,cascade: ['persist', 'remove'])]
    private Collection $commentBlogs;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: RendezVous::class,cascade: ['persist', 'remove'])]
    private Collection $rendezVousesP;

    #[ORM\OneToMany(mappedBy: 'id_personnel', targetEntity: RendezVous::class,cascade: ['persist', 'remove'])]
    //#[Groups(['user:read'])]
    private Collection $rendezVouses;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Centre $centre = null;

    #[ORM\ManyToMany(targetEntity: CreneauHoraire::class, mappedBy: 'psychologue')]
    private Collection $creneauHoraires;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->raitings = new ArrayCollection();
        $this->userCertifs = new ArrayCollection();
        $this->commentBlogs = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();
        $this->creneauHoraires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->num_tel;
    }

    public function setNumTel(string $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

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
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

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
            $reservation->setUser($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUser() === $this) {
                $reservation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setIdPersonnel($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getIdPersonnel() === $this) {
                $inscription->setIdPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Raiting>
     */
    public function getRaitings(): Collection
    {
        return $this->raitings;
    }

    public function addRaiting(Raiting $raiting): self
    {
        if (!$this->raitings->contains($raiting)) {
            $this->raitings->add($raiting);
            $raiting->setUser($this);
        }

        return $this;
    }

    public function removeRaiting(Raiting $raiting): self
    {
        if ($this->raitings->removeElement($raiting)) {
            // set the owning side to null (unless already changed)
            if ($raiting->getUser() === $this) {
                $raiting->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCertif>
     */
    public function getUserCertifs(): Collection
    {
        return $this->userCertifs;
    }

    public function addUserCertif(UserCertif $userCertif): self
    {
        if (!$this->userCertifs->contains($userCertif)) {
            $this->userCertifs->add($userCertif);
            $userCertif->setIdPersonnel($this);
        }

        return $this;
    }

    public function removeUserCertif(UserCertif $userCertif): self
    {
        if ($this->userCertifs->removeElement($userCertif)) {
            // set the owning side to null (unless already changed)
            if ($userCertif->getIdPersonnel() === $this) {
                $userCertif->setIdPersonnel(null);
            }
        }

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
            $commentBlog->setUser($this);
        }

        return $this;
    }

    public function removeCommentBlog(CommentBlog $commentBlog): self
    {
        if ($this->commentBlogs->removeElement($commentBlog)) {
            // set the owning side to null (unless already changed)
            if ($commentBlog->getUser() === $this) {
                $commentBlog->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVousesP(): Collection
    {
        return $this->rendezVousesP;
    }

    public function addRendezVouseP(RendezVous $rendezVousesP): self
    {
        if (!$this->rendezVousesP->contains($rendezVousesP)) {
            $this->rendezVousesP->add($rendezVousesP);
            $rendezVousesP->setClient($this);
        }

        return $this;
    }

    public function removeRendezVouseP(RendezVous $rendezVousesP): self
    {
        if ($this->rendezVousesP->removeElement($rendezVousesP)) {
            // set the owning side to null (unless already changed)
            if ($rendezVousesP->getClient() === $this) {
                $rendezVousesP->setClient(null);
            }
        }

        return $this;
    }



    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouses): self
    {
        if (!$this->rendezVouses->contains($rendezVouses)) {
            $this->rendezVouses->add($rendezVouses);
            $rendezVouses->setClient($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouses): self
    {
        if ($this->rendezVouses->removeElement($rendezVouses)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouses->getClient() === $this) {
                $rendezVouses->setClient(null);
            }
        }

        return $this;
    }

    public function getCentre(): ?Centre
    {
        return $this->centre;
    }

    public function setCentre(?Centre $centre): self
    {
        $this->centre = $centre;

        return $this;
    }

    /**
     * @return Collection<int, CreneauHoraire>
     */
    public function getCreneauHoraires(): Collection
    {
        return $this->creneauHoraires;
    }

    public function addCreneauHoraire(CreneauHoraire $creneauHoraire): self
    {
        if (!$this->creneauHoraires->contains($creneauHoraire)) {
            $this->creneauHoraires->add($creneauHoraire);
            $creneauHoraire->addPsychologue($this);
        }

        return $this;
    }

    public function removeCreneauHoraire(CreneauHoraire $creneauHoraire): self
    {
        if ($this->creneauHoraires->removeElement($creneauHoraire)) {
            $creneauHoraire->removePsychologue($this);
        }

        return $this;
    }
}
