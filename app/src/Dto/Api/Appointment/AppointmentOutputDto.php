<?php

declare(strict_types=1);

namespace App\Dto\Api\Appointment;

use App\Entity\Appointment;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;

class AppointmentOutputDto
{
    #[Groups(['Appointment:read'])]
    public int $id;

    #[Groups(['Appointment:read'])]
    public string $title;

    #[Groups(['Appointment:read'])]
    public ?string $description;

    #[Groups(['Appointment:read'])]
    public DateTimeImmutable $schedule;

    #[Groups(['Appointment:read'])]
    public float $price;

    #[Groups(['Appointment:read'])]
    public string $status;

    #[Groups(['Appointment:read'])]
    public DateTimeImmutable $createdAt;

    #[Groups(['Appointment:read'])]
    public ?DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        string $title,
        ?string $description,
        DateTimeImmutable $schedule,
        float $price,
        string $status,
        DateTimeImmutable $createdAt,
        ?DateTimeImmutable $updatedAt,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->schedule = $schedule;
        $this->price = $price;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function createFromAppointment(Appointment $appointment): self
    {
        return new self(
            $appointment->getId(),
            $appointment->getTitle(),
            $appointment->getDescription(),
            $appointment->getSchedule(),
            $appointment->getPrice(),
            $appointment->getStatus(),
            $appointment->getCreatedAt(),
            $appointment->getUpdatedAt(),
        );
    }
}
