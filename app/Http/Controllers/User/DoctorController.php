<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $doctors = Doctor::paginate(20); // You can adjust the number per page as needed
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

}
