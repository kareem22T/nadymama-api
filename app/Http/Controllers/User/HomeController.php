<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponser;

class HomeController extends Controller
{
    use ApiResponser;
    public function get() {
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
}
