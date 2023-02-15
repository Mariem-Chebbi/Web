<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'Type_utilisateur', type: 'string')]
#[ORM\DiscriminatorMap(['client' => Client::class, 'super_administrateur' => SuperAdministrateur::class, 'Personnel' => Personnel::class])]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Mot_de_passe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Num_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $Ville = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_naissance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->Mot_de_passe;
    }

    public function setMotDePasse(string $Mot_de_passe): self
    {
        $this->Mot_de_passe = $Mot_de_passe;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->Num_tel;
    }

    public function setNumTel(?string $Num_tel): self
    {
        $this->Num_tel = $Num_tel;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->Date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $Date_naissance): self
    {
        $this->Date_naissance = $Date_naissance;

        return $this;
    }
}
