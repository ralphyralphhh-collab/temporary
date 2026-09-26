<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customers')]
#[ORM\UniqueConstraint(name: 'uq_customers_email', columns: ['email'])]
class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $fullName;

    #[ORM\Column(length: 150, unique: true)]
    private string $email;

    #[ORM\Column(name: 'password_hash', length: 255)]
    private string $password;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: MerchOrder::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getFullName(): string { return $this->fullName; }
    public function setFullName(string $v): static { $this->fullName = $v; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $v): static { $this->email = $v; return $this; }

    // --- UserInterface ---

    public function getUserIdentifier(): string { return $this->email; }

    public function getRoles(): array { return ['ROLE_CUSTOMER']; }

    public function eraseCredentials(): void {}

    // --- PasswordAuthenticatedUserInterface ---

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $hash): static { $this->password = $hash; return $this; }

    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
