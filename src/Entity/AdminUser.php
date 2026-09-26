<?php

namespace App\Entity;

use App\Repository\AdminUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminUserRepository::class)]
#[ORM\Table(name: 'admin_users')]
#[ORM\UniqueConstraint(name: 'uq_admin_username', columns: ['username'])]
class AdminUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private string $username;

    #[ORM\Column(name: 'password_hash', length: 255)]
    private string $password;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getUsername(): string { return $this->username; }
    public function setUsername(string $v): static { $this->username = $v; return $this; }

    public function getUserIdentifier(): string { return $this->username; }

    public function getRoles(): array { return ['ROLE_ADMIN']; }

    public function eraseCredentials(): void {}

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $hash): static { $this->password = $hash; return $this; }
}
