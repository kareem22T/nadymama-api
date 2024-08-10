<?php

namespace App\Repositories;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Exception;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    protected $model;

    public function __construct(Appointment $appointment)
    {
        $this->model = $appointment;
    }

    public function getAppointmentPerDoctor($request)
    {
        return $request->user()->appointments()->latest()->get();
    }

    public function getAppointmentPerUser($request)
    {
        return $request->user()->appointments()->get();
    }

    public function book(array $data)
    {
        DB::beginTransaction();

        try {
            $appointment = $this->model->create($data);
            DB::commit();
            return $appointment;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
