<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class Doctor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'description', 'specialization', 'photo', 'specialization_id', 'degree', 'examination_price', 'special_examination_price', 'way_of_waiting', 'username', 'password'
    ];

    public function phones()
    {
        return $this->hasMany(DoctorPhone::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
