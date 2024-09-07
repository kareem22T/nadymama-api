<?php
namespace App\Services;

use App\Repositories\GouvernoratRepositoryInterface;

class GouvernoratService
{
    protected $gouvernoratRepository;

    public function __construct(GouvernoratRepositoryInterface $gouvernoratRepository)
    {
        $this->gouvernoratRepository = $gouvernoratRepository;
    }

    public function getAllGouvernorats()
    {
        return $this->gouvernoratRepository->all();
    }

    public function getGouvernoratById($id)
    {
        return $this->gouvernoratRepository->find($id);
    }

    public function createGouvernorat(array $data)
    {
        return $this->gouvernoratRepository->create($data);
    }

    public function updateGouvernorat($id, array $data)
    {
        return $this->gouvernoratRepository->update($id, $data);
    }

    public function deleteGouvernorat($id)
    {
        return $this->gouvernoratRepository->delete($id);
    }
}
