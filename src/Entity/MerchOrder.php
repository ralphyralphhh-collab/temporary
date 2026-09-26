<?php

namespace App\Entity;

use App\Repository\MerchOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MerchOrderRepository::class)]
#[ORM\Table(name: 'merch_orders')]
class MerchOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: 'customer_id', nullable: false, onDelete: 'CASCADE')]
    private Customer $customer;

    #[ORM\Column(length: 50)]
    private string $product;

    #[ORM\Column(type: 'integer')]
    private int $quantity = 1;

    #[ORM\Column(name: 'unit_price', type: 'decimal', precision: 10, scale: 2)]
    private string $unitPrice;

    #[ORM\Column(length: 255)]
    private string $location;

    #[ORM\Column(name: 'contact_number', length: 30)]
    private string $contactNumber;

    #[ORM\Column(length: 20)]
    private string $status = 'pending';

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getCustomer(): Customer { return $this->customer; }
    public function setCustomer(Customer $v): static { $this->customer = $v; return $this; }

    public function getProduct(): string { return $this->product; }
    public function setProduct(string $v): static { $this->product = $v; return $this; }

    public function getQuantity(): int { return $this->quantity; }
    public function setQuantity(int $v): static { $this->quantity = $v; return $this; }

    public function getUnitPrice(): string { return $this->unitPrice; }
    public function setUnitPrice(string $v): static { $this->unitPrice = $v; return $this; }

    public function getLocation(): string { return $this->location; }
    public function setLocation(string $v): static { $this->location = $v; return $this; }

    public function getContactNumber(): string { return $this->contactNumber; }
    public function setContactNumber(string $v): static { $this->contactNumber = $v; return $this; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $v): static { $this->status = $v; return $this; }
}
