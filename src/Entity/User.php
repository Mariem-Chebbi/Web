<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\Mapping\ClassMetadata;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    //#[Assert\NotNull(message: "Veuillez choisir un user")]


    #[Groups("Formation_list")]
    private ?int $id = null;


    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "Veuillez saisire un email ")]
    #[Assert\Regex(pattern: "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", message: "Veuillez saisire un email valide")]
    #[Groups("Formation_list")]
    private ?string $email = null;


    #[Assert\NotBlank(message: "Veuillez choisir un ou plusieur roles")]
    #[ORM\Column(length: 255)]
    #[Groups("Formation_list")]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    // ...

        /**
         * @Assert\NotBlank
         * @Assert\Length(min=8, max=4096)
         */
    private ?string $password = null;
    // ...

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir votre nom")]
    #[Groups("Formation_list")]
    private ?string $nom = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir votre prenom")]
    #[Groups("Formation_list")]
    private ?string $prenom = null;


    #[Assert\NotBlank(message: "Veuillez saisir votre numero de telephone")]
// ...
        /**
         * @ORM\Column(type="string", length=20, nullable=true)
         * @Assert\Regex(pattern="/^[0-9]{8}$/", message="Le numéro de téléphone doit comporter 8 chiffres.")
         */
    #[Groups("Formation_list")]
    private ?string $num_tel = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir votre ville")]
    #[Groups("Formation_list")]
    private ?string $ville = null;


    #[Groups("Formation_list")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Veuillez choisir une image")]
    #[Groups("Formation_list")]
    private ?string $image = null;

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
        return (string)$this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->email;
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

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
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

    public function setDateNaissance(\DateTimeInterface $date_naissance = NULL): self
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

    // ...

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('password', new Assert\Length([
            'min' => 8,
            'max' => 20,
        ]));
    }


    public function jsonSerialize(): array
    {
        $role = "ROLE_USER";

        if ($this->roles) {
            $role = $this->roles[0];
        }

        return array(
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $role,
            'password' => $this->password,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'ville' => $this->ville,
            'dateNaissance' => $this->date_naissance->format("d-m-Y"),
            'image' => $this->image
        );
    }

    public function constructor($email, $nom, $prenom, $ville, $dateNaissance, $image)
    {
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->ville = $ville;
        $this->date_naissance = $dateNaissance;
        $this->image = $image;
    }
}
