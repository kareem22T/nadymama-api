<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Services\PositionService;
use App\Traits\ApiResponser;

class PositionController extends Controller
{
    use ApiResponser;

    protected $positionService;

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    public function index()
    {
        $positions = $this->positionService->getAllPositions();
        return $this->successResponse($positions);
    }

    public function store(StorePositionRequest $request)
    {
        $position = $this->positionService->createPosition($request->validated());
        return $this->successResponse($position, 'Position created successfully', 201);
    }

    public function show($id)
    {
        $position = $this->positionService->getPositionById($id);
        return $this->successResponse($position);
    }

    public function update(UpdatePositionRequest $request, $id)
    {
        $position = $this->positionService->updatePosition($id, $request->validated());
        return $this->successResponse($position, 'Position updated successfully');
    }

    public function destroy($id)
    {
        $this->positionService->deletePosition($id);
        return $this->successResponse(null, 'Position deleted successfully', 204);
    }
}
