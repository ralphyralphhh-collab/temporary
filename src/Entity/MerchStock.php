<?php

namespace App\Entity;

use App\Repository\MerchStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MerchStockRepository::class)]
#[ORM\Table(name: 'merch_stock')]
class MerchStock
{
    #[ORM\Id]
    #[ORM\Column(length: 50)]
    private string $product;

    #[ORM\Column(name: 'stock_quantity', type: 'integer')]
    private int $stockQuantity = 1000;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $price = '0.00';

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getProduct(): string { return $this->product; }
    public function setProduct(string $v): static { $this->product = $v; return $this; }

    public function getStockQuantity(): int { return $this->stockQuantity; }
    public function setStockQuantity(int $v): static { $this->stockQuantity = $v; return $this; }

    public function getPrice(): string { return $this->price; }
    public function setPrice(string $v): static { $this->price = $v; return $this; }
}
