<?php

namespace App\Entity;

use App\Repository\PersonnelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnelRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'Type_personnel', type: 'string')]
#[ORM\DiscriminatorMap(['gestionnaire_stock' => GestionnaireStock::class, 'Administrateur_centre' => AdministrateurCentre::class, 'Assistant_psychologique' => AssistantPsychologique::class])]
class Personnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Cin = null;

    #[ORM\OneToMany(mappedBy: 'id_personnel', targetEntity: Inscription::class)]
    private Collection $inscriptions;

    #[ORM\OneToMany(mappedBy: 'id_personnel', targetEntity: Notification::class)]
    private Collection $notifications;

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    private ?centre $id_centre = null;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?string
    {
        return $this->Cin;
    }

    public function setCin(string $Cin): self
    {
        $this->Cin = $Cin;

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
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setIdPersonnel($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getIdPersonnel() === $this) {
                $notification->setIdPersonnel(null);
            }
        }

        return $this;
    }

    public function getIdCentre(): ?centre
    {
        return $this->id_centre;
    }

    public function setIdCentre(?centre $id_centre): self
    {
        $this->id_centre = $id_centre;

        return $this;
    }
}
