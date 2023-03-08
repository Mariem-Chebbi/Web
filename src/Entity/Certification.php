<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CertificationRepository::class)]
class Certification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"image is required")]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"date is required")]
    private ?\DateTimeInterface $dateCertif = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Assert\NotBlank(message:"formation is required")]
    private ?Formation $idFormation = null;

    #[ORM\OneToMany(mappedBy: 'id_certif', targetEntity: UserCertif::class)]
    private Collection $userCertifs;

    public function __construct()
    {
        $this->userCertifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateCertif(): ?\DateTimeInterface
    {
        return $this->dateCertif;
    }

    public function setDateCertif(\DateTimeInterface $dateCertif): self
    {
        $this->dateCertif = $dateCertif;

        return $this;
    }

    public function getIdFormation(): ?Formation
    {
        return $this->idFormation;
    }

    public function setIdFormation(?Formation $idFormation): self
    {
        $this->idFormation = $idFormation;

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
            $userCertif->setIdCertif($this);
        }

        return $this;
    }

    public function removeUserCertif(UserCertif $userCertif): self
    {
        if ($this->userCertifs->removeElement($userCertif)) {
            // set the owning side to null (unless already changed)
            if ($userCertif->getIdCertif() === $this) {
                $userCertif->setIdCertif(null);
            }
        }

        return $this;
    }
}
