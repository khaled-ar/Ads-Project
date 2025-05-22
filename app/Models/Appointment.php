<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = ['status'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function center() {
        return $this->belongsTo(Center::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }
}
