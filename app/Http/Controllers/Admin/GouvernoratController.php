<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGouvernoratRequest;
use App\Http\Requests\UpdateGouvernoratRequest;
use App\Services\GouvernoratService;
use App\Traits\ApiResponser;

class GouvernoratController extends Controller
{
    use ApiResponser;

    protected $gouvernoratService;

    public function __construct(GouvernoratService $gouvernoratService)
    {
        $this->gouvernoratService = $gouvernoratService;
    }

    public function index()
    {
        $gouvernorats = $this->gouvernoratService->getAllGouvernorats();
        return $this->successResponse($gouvernorats);
    }

    public function store(StoreGouvernoratRequest $request)
    {
        $gouvernorat = $this->gouvernoratService->createGouvernorat($request->validated());
        return $this->successResponse($gouvernorat, 'Gouvernorat created successfully', 201);
    }

    public function show($id)
    {
        $gouvernorat = $this->gouvernoratService->getGouvernoratById($id);
        return $this->successResponse($gouvernorat);
    }

    public function update(UpdateGouvernoratRequest $request, $id)
    {
        $gouvernorat = $this->gouvernoratService->updateGouvernorat($id, $request->validated());
        return $this->successResponse($gouvernorat, 'Gouvernorat updated successfully');
    }

    public function destroy($id)
    {
        $this->gouvernoratService->deleteGouvernorat($id);
        return $this->successResponse(null, 'Gouvernorat deleted successfully', 204);
    }
}
