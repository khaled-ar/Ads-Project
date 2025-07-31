<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverTrip extends Model
{
    use HasFactory;

    /**
     * The attributes that not are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

}
