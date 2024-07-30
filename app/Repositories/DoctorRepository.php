<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\DoctorPhone;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorRepository implements DoctorRepositoryInterface
{
    protected $model;

    public function __construct(Doctor $doctor)
    {
        $this->model = $doctor;
    }

    public function all()
    {
        return $this->model->with('phones', 'category')->get();
    }

    public function find($id)
    {
        return $this->model->with('phones', 'category')->findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            if (isset($data['photo'])) {
                $data['photo'] = $this->storePhoto($data['photo']);
            }

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

            if (isset($data['photo'])) {
                $data['photo'] = $this->storePhoto($data['photo']);
            }

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

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

    protected function storePhoto($photo)
    {
        $path = $photo->store('photos', 'public'); // stores the photo in the 'storage/app/public/photos' directory
        return $path;
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
