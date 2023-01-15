<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
#[ApiResource]
class Appointment
{
    public const STATUS_CREATED = 'created';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [
        self::STATUS_CREATED,
        self::STATUS_COMPLETED,
        self::STATUS_CLOSED,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    private User $user;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private DateTimeImmutable $schedule;

    #[ORM\Column]
    private float $price;

    #[ORM\Column(length: 255)]
    private string $status;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\JoinTable(name: 'appointments_media_objects')]
    #[ORM\JoinColumn(name: 'appointment_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'media_object_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: 'MediaObject')]
    // #[ORM\OneToMany(mappedBy: 'appointment', targetEntity: MediaObject::class)]
    private Collection $mediaObjects;

    public function __construct(
        User $user,
        string $title,
        ?string $description,
        DateTimeImmutable $schedule,
        float $price
    )
    {
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
        $this->schedule = $schedule;
        $this->price = $price;
        $this->mediaObjects = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSchedule(): DateTimeImmutable
    {
        return $this->schedule;
    }

    public function setSchedule(DateTimeImmutable $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, self::STATUSES)) {
            throw new \InvalidArgumentException('Invalid status provided');
        }

        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, MediaObject>
     */
    public function getMediaObjects(): Collection
    {
        return $this->mediaObjects;
    }

    public function addMediaObjectId(MediaObject $mediaObject): self
    {
        $this->mediaObjects->add($mediaObject);

        return $this;
    }

    public function removeMediaObjectId(MediaObject $mediaObject): self
    {
        $this->mediaObjects->removeElement($mediaObject);

        return $this;
    }
}
