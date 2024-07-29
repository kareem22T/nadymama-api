<?php
namespace App\Services;

use App\Repositories\AppointmentRepositoryInterface;

class AppointmentService
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function getAppointmentPerDoctor($request)
    {
        return $this->appointmentRepository->getAppointmentPerDoctor($request);
    }

    public function getAppointmentPerUser($request)
    {
        return $this->appointmentRepository->getAppointmentPerUser($request);
    }

    public function book(array $data)
    {
        return $this->appointmentRepository->book($data);
    }
}
