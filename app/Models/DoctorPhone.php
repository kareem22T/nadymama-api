<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorPhone extends Model
{
    protected $fillable = ['doctor_id', 'phone'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public $table = "doctor_phones";
}
