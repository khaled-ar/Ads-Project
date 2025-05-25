<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverAd extends Model
{
    use HasFactory;

    protected $table = 'drivers_ads';
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'created_at',
        'driver_id',
        'ad_id'
    ];

    public function driver() {
        return $this->belongsTo(Driver::class)->select([
            'id',
            'user_id',
            'car_model',
            'car_year',
            'gender',
            'nationality'
        ]);
    }

    public function ad() {
        return $this->belongsTo(Ad::class);
    }
}
