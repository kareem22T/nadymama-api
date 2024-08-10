<?php

namespace App\Repositories;

use App\Models\Position;
use App\Models\PositionPhone;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;

class PositionRepository implements PositionRepositoryInterface
{
    protected $model;

    public function __construct(Position $position)
    {
        $this->model = $position;
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
            $position = $this->model->create($data);
            DB::commit();
            return $position;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $position = $this->model->findOrFail($id);
            $position->update($data);
            DB::commit();
            return $position;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $position = $this->model->findOrFail($id);
            $position->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
