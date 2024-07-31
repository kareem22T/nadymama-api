<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::with('doctors')->get();
        return response()->json($specializations);
    }

    public function getDoctorsBySpecialization($specializationId, Request $request)
    {
        $specialization = Specialization::find($specializationId);

        if (!$specialization) {
            return response()->json(['error' => 'Specialization not found'], 404);
        }

        $perPage = $request->query('per_page', 20); // Default to 10 items per page if not specified

        $doctors = $specialization->doctors()->paginate($perPage);

        return response()->json($doctors);
    }
}
