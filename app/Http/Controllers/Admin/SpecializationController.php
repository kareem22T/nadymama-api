<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpecializationRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use App\Services\SpecializationService;
use App\Traits\ApiResponser;

class SpecializationController extends Controller
{
    use ApiResponser;

    protected $specializationService;

    public function __construct(SpecializationService $specializationService)
    {
        $this->specializationService = $specializationService;
    }

    public function index()
    {
        $specializations = $this->specializationService->getAllSpecializations();
        return $this->successResponse($specializations);
    }

    public function store(StoreSpecializationRequest $request)
    {
        $specialization = $this->specializationService->createSpecialization($request->validated());
        return $this->successResponse($specialization, 'Specialization created successfully', 201);
    }

    public function show($id)
    {
        $specialization = $this->specializationService->getSpecializationById($id);
        return $this->successResponse($specialization);
    }

    public function update(UpdateSpecializationRequest $request, $id)
    {
        $specialization = $this->specializationService->updateSpecialization($id, $request->validated());
        return $this->successResponse($specialization, 'Specialization updated successfully');
    }

    public function destroy($id)
    {
        $this->specializationService->deleteSpecialization($id);
        return $this->successResponse(null, 'Specialization deleted successfully', 204);
    }
}
