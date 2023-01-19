<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MediaObjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: MediaObjectRepository::class)]
#[ApiResource]
class MediaObject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: Types::TEXT)]
    private string $path;

    #[ORM\Column(nullable: true)]
    private ?array $meta = [];

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(inversedBy: 'mediaObjects')]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    public function __construct(
        string $path,
        ?array $meta,
        User $owner
    )
    {
        $this->path = $path;
        $this->meta = $meta;
        $this->owner = $owner;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function setMeta(?array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }
}
