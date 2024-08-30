<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiResponser;

    public function get()
    {
        $settings = Setting::all();

        // Transform settings into an associative array.
        $settingsArray = $settings->mapWithKeys(function ($setting) {
            return [
                $setting->key => $setting->value
            ];
        })->toArray();

        return response()->json([
            "data" => $settingsArray
        ]);
    }

    // Method to paginate doctors
    public function paginateDoctors(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 doctors per page
        $doctors = Doctor::paginate($perPage);

        return response()->json([
            'data' => $doctors
        ]);
    }

    // Method to paginate doctors per category
    public function paginateDoctorsByCategory(Request $request, $categoryId)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 doctors per page
        $doctors = Doctor::where('specialization_id', $categoryId)->paginate($perPage);

        return response()->json([
            'data' => $doctors
        ]);
    }

    // Method to get all categories
    public function getAllCategories()
    {
        $categories = Specialization::all();

        return response()->json([
            'data' => $categories
        ]);
    }
}
