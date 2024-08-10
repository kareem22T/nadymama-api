<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Services\DoctorService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    use ApiResponser;

    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function index()
    {
        $doctors = $this->doctorService->getAllDoctors();
        return $this->successResponse($doctors);
    }

    public function store(StoreDoctorRequest $request)
    {
        $doctor = $this->doctorService->createDoctor($request->validated());
        return $this->successResponse($doctor, 'Doctor created successfully', 201);
    }

    public function show($id)
    {
        $doctor = $this->doctorService->getDoctorById($id);
        return $this->successResponse($doctor);
    }

    public function update(Request $request, $id)
    {
        return $request;
        $doctor = $this->doctorService->updateDoctor($id, $request->validated());
        return $this->successResponse($doctor, 'Doctor updated successfully');
    }

    public function destroy($id)
    {
        $this->doctorService->deleteDoctor($id);
        return $this->successResponse(null, 'Doctor deleted successfully', 204);
    }
}
