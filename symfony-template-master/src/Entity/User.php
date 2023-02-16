<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'bookingHasUser', targetEntity: Booking::class, orphanRemoval: true)]
    private Collection $bookingHasUser;

    #[ORM\OneToMany(mappedBy: 'relatedCommercial', targetEntity: Booking::class)]
    private Collection $relatedCommercialBooking;


    public function __construct()
    {
        $this->bookingHasUser = new ArrayCollection();
        $this->relatedCommercialBooking = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->email;
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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookingHasUser(): Collection
    {
        return $this->bookingHasUser;
    }

    public function addBookingHasUser(Booking $bookingHasUser): self
    {
        if (!$this->bookingHasUser->contains($bookingHasUser)) {
            $this->bookingHasUser->add($bookingHasUser);
            $bookingHasUser->setBookingHasUser($this);
        }

        return $this;
    }

    public function removeBookingHasUser(Booking $bookingHasUser): self
    {
        if ($this->bookingHasUser->removeElement($bookingHasUser)) {
            // set the owning side to null (unless already changed)
            if ($bookingHasUser->getBookingHasUser() === $this) {
                $bookingHasUser->setBookingHasUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getRelatedCommercialBooking(): Collection
    {
        return $this->relatedCommercialBooking;
    }

    public function addRelatedCommercialBooking(Booking $relatedCommercialBooking): self
    {
        if (!$this->relatedCommercialBooking->contains($relatedCommercialBooking)) {
            $this->relatedCommercialBooking->add($relatedCommercialBooking);
            $relatedCommercialBooking->setRelatedCommercial($this);
        }

        return $this;
    }

    public function removeRelatedCommercialBooking(Booking $relatedCommercialBooking): self
    {
        if ($this->relatedCommercialBooking->removeElement($relatedCommercialBooking)) {
            // set the owning side to null (unless already changed)
            if ($relatedCommercialBooking->getRelatedCommercial() === $this) {
                $relatedCommercialBooking->setRelatedCommercial(null);
            }
        }

        return $this;
    }
}
