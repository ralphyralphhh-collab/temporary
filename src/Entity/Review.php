<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\Table(name: 'reviews')]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'reviewer_name', length: 100)]
    private string $reviewerName;

    #[ORM\Column(type: 'smallint')]
    private int $rating = 5;

    #[ORM\Column(name: 'review_text', type: 'text')]
    private string $reviewText;

    #[ORM\Column(name: 'is_published', type: 'boolean')]
    private bool $isPublished = false;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getReviewerName(): string { return $this->reviewerName; }
    public function setReviewerName(string $v): static { $this->reviewerName = $v; return $this; }

    public function getRating(): int { return $this->rating; }
    public function setRating(int $v): static { $this->rating = max(1, min(5, $v)); return $this; }

    public function getReviewText(): string { return $this->reviewText; }
    public function setReviewText(string $v): static { $this->reviewText = $v; return $this; }

    public function isPublished(): bool { return $this->isPublished; }
    public function setIsPublished(bool $v): static { $this->isPublished = $v; return $this; }
}
