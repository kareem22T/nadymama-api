<?php

namespace App\Repositories;

use App\Models\Specialization;
use App\Models\SpecializationPhone;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;

class SpecializationRepository implements SpecializationRepositoryInterface
{
    protected $model;

    public function __construct(Specialization $specialization)
    {
        $this->model = $specialization;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $specialization = $this->model->create($data);
            DB::commit();
            return $specialization;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $specialization = $this->model->findOrFail($id);
            $specialization->update($data);
            DB::commit();
            return $specialization;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $specialization = $this->model->findOrFail($id);
            $specialization->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
