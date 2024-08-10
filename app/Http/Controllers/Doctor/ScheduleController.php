<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\BusyDay;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    use ApiResponser;

    public function create(Request $request)
    {
        $doctor = $request->user();
        // Validate the input
        $data = $request->validate([
            'type' => 'required|in:1,2', // 1 for day, 2 for date
            'value' => 'required'
        ]);

        $data['doctor_id'] = $doctor->id;

        // Check the value based on the type
        if ($data['type'] == 1) {
            // If type is 1 (day), the value should be between 1 and 7
            if ($data['value'] < 1 || $data['value'] > 7) {
                return $this->validationErrorResponse(['value' => 'The value must be between 1 and 7 for days.']);
            }
        } else {
            // If type is 2 (date), the value should be a valid date
            $data['value'] = date('Y-m-d', strtotime($data['value']));
            if (!$data['value']) {
                return $this->validationErrorResponse(['value' => 'The value must be a valid date.']);
            }
        }

        // Create the busy day
        BusyDay::create($data);

        return $this->successResponse($data, 'Busy day created successfully.', 201);
    }
}
