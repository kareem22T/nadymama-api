<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use ApiResponser;

    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function get(Request $request) {
        $appointments = $this->appointmentService->getAppointmentPerDoctor($request);
        return $this->successResponse($appointments);
    }

}
