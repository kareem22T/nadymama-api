<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Position;
use App\Models\Specialization;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        // Start with the base query
        $query = Doctor::with("position");

        // Apply filters based on the query parameters
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->query('name') . '%');
        }

        if ($request->has('position_id')) {
            $query->where('position_id', 'like', '%' . $request->query('position_id') . '%');
        }

        if ($request->has('specialization_id')) {
            $query->where('specialization_id', 'like', '%' . $request->query('specialization_id') . '%');
        }

        // Paginate the results
        $doctors = $query->paginate(20); // Adjust the per-page count as needed

        // Return the results as JSON
        return response()->json($doctors);
    }

    public function doctor($doctorId)
    {
        $doctor = Doctor::with(["phones", "position", "category"])->find($doctorId);

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        return response()->json($doctor);
    }

    public function getAllCategories() {
        $specializations = Specialization::all();
        return response()->json($specializations);
    }

    public function getAllPositions() {
        $positions = Position::all();
        return response()->json($positions);
    }

}
