<?php

namespace App\Entity;

use App\Repository\CentreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\FormBuilderInterface;

use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;



use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CentreRepository::class)]
class Centre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez compléter ce champ.")]
    private ?string $Nom_social = null;    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez compléter ce champ.")]
    private ?string $Aderesse = null;

    #[ORM\Column(length: 255)]
    private ?string $Ville = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez compléter ce champ.")]
    private ?string $Logo = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez compléter ce champ.")]
    
    //#[Assert\Regex('"+"[0-9]+')]
    #[Assert\Regex('/^[0-9]+$/i',message:"Veuillez entrer un numero de telephone valide.")]
    private ?string $Tel1 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez compléter ce champ.")]

    #[Assert\Regex('/^[0-9]+$/i')]
    private ?string $Tel2 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"description is required")]
    private ?string $Description = null;

    #[ORM\ManyToMany(targetEntity: Services::class, inversedBy: 'centres')]
    #[Assert\NotBlank(message:"service is required")]
    private Collection $idServices;

    public function __construct()
    {
        $this->idServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSocial(): ?string
    {
        return $this->Nom_social;
    }

    public function setNomSocial(string $Nom_social): self
    {
        $this->Nom_social = $Nom_social;

        return $this;
    }

    public function getAderesse(): ?string
    {
        return $this->Aderesse;
    }

    public function setAderesse(string $Aderesse): self
    {
        $this->Aderesse = $Aderesse;

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

    public function getLogo(): ?string
    {
        return $this->Logo;
    }

    public function setLogo(string $Logo): self
    {
        $this->Logo = $Logo;

        return $this;
    }

    public function getTel1(): ?string
    {
        return $this->Tel1;
    }

    public function setTel1(string $Tel1): self
    {
        $this->Tel1 = $Tel1;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->Tel2;
    }

    public function setTel2(string $Tel2): self
    {
        $this->Tel2 = $Tel2;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Services>
     */
    public function getIdServices(): Collection
    {
        return $this->idServices;
    }

    public function addIdService(Services $idService): self
    {
        if (!$this->idServices->contains($idService)) {
            $this->idServices->add($idService);
        }

        return $this;
    }

    public function removeIdService(Services $idService): self
    {
        $this->idServices->removeElement($idService);

        return $this;
    }
}
