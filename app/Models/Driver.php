<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Files;
use Illuminate\Notifications\Notifiable;

class Driver extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that not are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'personal_id_image',
        'driving_license_image',
        'car_mechanics_image',
    ];

    protected $appends = [
        'personal_id_image_url',
        'driving_license_image_url',
        'car_mechanics_image_url'
    ];

    public function getPersonalIdImageUrlAttribute()
    {
        return asset("Drivers_Images") . '/' . $this->personal_id_image;
    }

    public function getDrivingLicenseImageUrlAttribute()
    {
        return asset("Drivers_Images") . '/' . $this->driving_license_image;
    }

    public function getCarMechanicsImageUrlAttribute()
    {
        return asset("Drivers_Images") . '/' . $this->car_mechanics_image;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($driver) {
            // Create custom work status value
            if ($driver->work_status == 'يعمل ضمن برنامج توصيل') {
                $driver->work_status = $driver->work_status . ', ' . request('program_name');
            }
        });

        static::created(function ($driver) {
            $driver->personal_id_image = Files::moveFile(request('personal_id_image'), "Drivers_Images");
            $driver->driving_license_image = Files::moveFile(request('driving_license_image'), "Drivers_Images");
            $driver->car_mechanics_image = Files::moveFile(request('car_mechanics_image'), "Drivers_Images");
            $driver->save();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ads()
    {
        return $this->hasMany(DriverAd::class)->with('ad.user');
    }

    public function activeAdsNumber() {
        return $this->hasMany(DriverAd::class)->where('status', 'in_progress')->orWhere('status', 'approval_wating')->count();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class)->with('center');
    }
}
