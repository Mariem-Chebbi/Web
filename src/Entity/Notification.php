<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_notification = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNotification(): ?\DateTimeInterface
    {
        return $this->Date_notification;
    }

    public function setDateNotification(?\DateTimeInterface $Date_notification): self
    {
        $this->Date_notification = $Date_notification;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(?string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }
}
