<?php
namespace App\Services;

use App\Repositories\PositionRepositoryInterface;

class PositionService
{
    protected $positionRepository;

    public function __construct(PositionRepositoryInterface $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function getAllPositions()
    {
        return $this->positionRepository->all();
    }

    public function getPositionById($id)
    {
        return $this->positionRepository->find($id);
    }

    public function createPosition(array $data)
    {
        return $this->positionRepository->create($data);
    }

    public function updatePosition($id, array $data)
    {
        return $this->positionRepository->update($id, $data);
    }

    public function deletePosition($id)
    {
        return $this->positionRepository->delete($id);
    }
}
