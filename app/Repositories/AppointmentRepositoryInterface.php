<?php
namespace App\Repositories;

interface AppointmentRepositoryInterface
{
    public function getAppointmentPerDoctor($request);
    public function getAppointmentPerUser($request);
    public function book(array $data);
}
