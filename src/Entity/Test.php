<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getdate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setdate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function gettime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function settime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
}
