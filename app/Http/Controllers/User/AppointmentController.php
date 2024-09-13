<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Appointment;
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
        $appointments = $this->appointmentService->getAppointmentPerUser($request);
        return $this->successResponse($appointments);
    }

    public function book(BookingRequest $request) {
        $validated_data = $request->validated();
        $validated_data['user_id'] = $request->user()->id;

        $appointment = $this->appointmentService->book($validated_data);
        return $this->successResponse($appointment);
    }

    public function getAll() {
        $appointments = Appointment::latest()->with(['doctor', 'user'])->paginate('10');
        return $appointments;
    }

}
