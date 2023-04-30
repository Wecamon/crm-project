<?php

declare(strict_types=1);

namespace App\DataTransformer\Api\Appointment;

use App\Dto\Api\Appointment\AppointmentOutputDto;
use App\Entity\Appointment;

class AppointmentOutputDataTransformer
{
    public function transform(Appointment $appointment): AppointmentOutputDto
    {
        return AppointmentOutputDto::createFromAppointment($appointment);
    }
}
