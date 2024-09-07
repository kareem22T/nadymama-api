<?php

namespace App\Repositories;

use App\Models\Gouvernorat;
use App\Models\GouvernoratPhone;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;

class GouvernoratRepository implements GouvernoratRepositoryInterface
{
    protected $model;

    public function __construct(Gouvernorat $gouvernorat)
    {
        $this->model = $gouvernorat;
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
            $gouvernorat = $this->model->create($data);
            DB::commit();
            return $gouvernorat;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $gouvernorat = $this->model->findOrFail($id);
            $gouvernorat->update($data);
            DB::commit();
            return $gouvernorat;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $gouvernorat = $this->model->findOrFail($id);
            $gouvernorat->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
