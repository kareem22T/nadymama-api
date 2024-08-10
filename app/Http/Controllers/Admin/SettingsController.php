<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Traits\ApiResponser;

class SettingsController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            if ($request->hasFile($key)) {
                $path = null;
                if (isset($value)) {
                    $path = $this->storePhoto($value);
                }
                Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            } else {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return $this->successResponse(null, 'Specialization deleted successfully', 204);
    }

    protected function storePhoto($photo)
    {
        $path = $photo->store('photos', 'public'); // stores the photo in the 'storage/app/public/photos' directory
        return $path;
    }

}
