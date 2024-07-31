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
}
