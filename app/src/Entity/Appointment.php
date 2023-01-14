<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
#[ApiResource]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    private User $user_id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private \DateTimeImmutable $schedule;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private string $price;

    #[ORM\Column(length: 255)]
    private string $status;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\JoinTable(name: 'appointments_media_objects')]
    #[ORM\JoinColumn(name: 'appointment_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'media_object_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: 'MediaObject')]
    // #[ORM\OneToMany(mappedBy: 'appointment', targetEntity: MediaObject::class)]
    private Collection $media_object_id;

    public function __construct()
    {
        $this->media_object_id = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
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

    public function getSchedule(): \DateTimeImmutable
    {
        return $this->schedule;
    }

    public function setSchedule(\DateTimeImmutable $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
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
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, MediaObject>
     */
    public function getMediaObjectId(): Collection
    {
        return $this->media_object_id;
    }

    // public function addMediaObjectId(MediaObject $mediaObjectId): self
    // {
    //     if (!$this->media_object_id->contains($mediaObjectId)) {
    //         $this->media_object_id->add($mediaObjectId);
    //         $mediaObjectId->setAppointment($this);
    //     }

    //     return $this;
    // }

    // public function removeMediaObjectId(MediaObject $mediaObjectId): self
    // {
    //     if ($this->media_object_id->removeElement($mediaObjectId)) {
    //         // set the owning side to null (unless already changed)
    //         if ($mediaObjectId->getAppointment() === $this) {
    //             $mediaObjectId->setAppointment(null);
    //         }
    //     }

    //     return $this;
    // }
}
