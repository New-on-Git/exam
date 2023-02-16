<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $beginAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'bookingHasUser')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $bookingHasUser = null;

    #[ORM\ManyToOne(inversedBy: 'relatedCommercialBooking')]
    private ?User $relatedCommercial = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(?\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBookingHasUser(): ?User
    {
        return $this->bookingHasUser;
    }

    public function setBookingHasUser(?User $bookingHasUser): self
    {
        $this->bookingHasUser = $bookingHasUser;

        return $this;
    }

    public function getRelatedCommercial(): ?User
    {
        return $this->relatedCommercial;
    }

    public function setRelatedCommercial(?User $relatedCommercial): self
    {
        $this->relatedCommercial = $relatedCommercial;

        return $this;
    }

}
