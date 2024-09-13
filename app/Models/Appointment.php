<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        "doctor_id",
        "user_id",
        "name",
        "email",
        'phone',
        "day"
    ];

        // Define the relationship to the Doctor model
        public function doctor()
        {
            return $this->belongsTo(Doctor::class);
        }

        // Define the relationship to the User model
        public function user()
        {
            return $this->belongsTo(User::class);
        }

}
