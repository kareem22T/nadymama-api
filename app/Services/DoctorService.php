<?php
namespace App\Services;

use App\Repositories\DoctorRepositoryInterface;

class DoctorService
{
    protected $doctorRepository;

    public function __construct(DoctorRepositoryInterface $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function getAllDoctors()
    {
        return $this->doctorRepository->all();
    }

    public function getDoctorById($id)
    {
        return $this->doctorRepository->find($id);
    }

    public function createDoctor(array $data)
    {
        return $this->doctorRepository->create($data);
    }

    public function updateDoctor($id, array $data)
    {
        return $this->doctorRepository->update($id, $data);
    }

    public function deleteDoctor($id)
    {
        return $this->doctorRepository->delete($id);
    }
}
