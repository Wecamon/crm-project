<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use App\Dto\UserOutput;
use App\Dto\PostUserInput;
use App\Dto\PatchUserInput;
use App\Dto\UsersOutput;
use App\State\PatchUserProcessor;
use App\State\PostUserProcessor;
use App\State\UserOutputProvider;
use App\State\UsersOutputProvider;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    operations: [
        new Get(output: UserOutput::class, provider: UserOutputProvider::class),
        new Post(input: PostUserInput::class, processor: PostUserProcessor::class),
        new Patch(input: PatchUserInput::class, processor: PatchUserProcessor::class),
        new GetCollection(output: UsersOutput::class, provider: UsersOutputProvider::class)
    ],
    normalizationContext:['groups' => ['User:read']],
    denormalizationContext:['groups' => ['User:write']]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email;

    #[ORM\Column(length: 255)]
    private string $phone;

    #[ORM\Column(length: 255)]
    private string $firstname;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname;

    #[ORM\Column(nullable: true)]
    private ?array $roles = [];

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Appointment::class)]
    private Collection $appointments;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: MediaObject::class)]
    private Collection $mediaObjects;

    public function __construct(
        ?string $email,
        string $phone,
        string $firstname,
        ?string $lastname,
    )
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->roles = ['ROLE_USER'];
        $this->appointments = new ArrayCollection();
        $this->mediaObjects = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): int
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
        }
        
        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        $this->appointments->removeElement($appointment);

        return $this;
    }

    /**
     * @return Collection<int, MediaObject>
     */
    public function getMediaObjects(): Collection
    {
        return $this->mediaObjects;
    }

    public function addMediaObject(MediaObject $mediaObject): self
    {
        if (!$this->mediaObjects->contains($mediaObject)) {
            $this->mediaObjects->add($mediaObject);
        }

        return $this;
    }

    public function removeMediaObject(MediaObject $mediaObject): self
    {
        $this->mediaObjects->removeElement($mediaObject);

        return $this;
    }
}
