<?php
namespace App\Services;

use App\Repositories\SpecializationRepositoryInterface;

class SpecializationService
{
    protected $specializationRepository;

    public function __construct(SpecializationRepositoryInterface $specializationRepository)
    {
        $this->specializationRepository = $specializationRepository;
    }

    public function getAllSpecializations()
    {
        return $this->specializationRepository->all();
    }

    public function getSpecializationById($id)
    {
        return $this->specializationRepository->find($id);
    }

    public function createSpecialization(array $data)
    {
        return $this->specializationRepository->create($data);
    }

    public function updateSpecialization($id, array $data)
    {
        return $this->specializationRepository->update($id, $data);
    }

    public function deleteSpecialization($id)
    {
        return $this->specializationRepository->delete($id);
    }
}
