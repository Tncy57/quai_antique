<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lunchOpening = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lunchClosing = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dinnerOpening = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dinnerClosing = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getLunchOpening(): ?\DateTimeInterface
    {
        return $this->lunchOpening;
    }

    public function setLunchOpening(\DateTimeInterface $lunchOpening): self
    {
        $this->lunchOpening = $lunchOpening;
        return $this;
    }

    public function getLunchClosing(): ?\DateTimeInterface
    {
        return $this->lunchClosing;
    }

    public function setLunchClosing(\DateTimeInterface $lunchClosing): self
    {
        $this->lunchClosing = $lunchClosing;
        return $this;
    }

    public function getDinnerOpening(): ?\DateTimeInterface
    {
        return $this->dinnerOpening;
    }

    public function setDinnerOpening(\DateTimeInterface $dinnerOpening): self
    {
        $this->dinnerOpening = $dinnerOpening;
        return $this;
    }

    public function getDinnerClosing(): ?\DateTimeInterface
    {
        return $this->dinnerClosing;
    }

    public function setDinnerClosing(\DateTimeInterface $dinnerClosing): self
    {
        $this->dinnerClosing = $dinnerClosing;
        return $this;
    }
}