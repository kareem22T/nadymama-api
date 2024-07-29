<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\DoctorPhone;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;

class DoctorRepository implements DoctorRepositoryInterface
{
    protected $model;

    public function __construct(Doctor $doctor)
    {
        $this->model = $doctor;
    }

    public function all()
    {
        return $this->model->with('phones')->get();
    }

    public function find($id)
    {
        return $this->model->with('phones')->findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $data['password'] = Hash::make($data['password']);
            $doctor = $this->model->create($data);
            foreach ($data['phones'] as $phone) {
                $doctor->phones()->create(["phone" => $phone]);
            }

            DB::commit();
            return $doctor;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $doctor = $this->model->findOrFail($id);
            if (isset($data['password']))
            $data['password'] = Hash::make($data['password']);
            $doctor->update($data);
            $doctor->phones()->delete();
            foreach ($data['phones'] as $phone) {
                $doctor->phones()->create(["phone" => $phone]);
            }
            DB::commit();
            return $doctor;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $doctor = $this->model->findOrFail($id);
            $doctor->phones()->delete();
            $doctor->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
