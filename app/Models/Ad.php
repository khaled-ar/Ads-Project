<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Files;


class Ad extends Model
{
    use HasFactory;

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
        'images'
    ];

    protected $appends = ['from', 'images_url', 'is_full'];

    public function getFromAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getImagesUrlAttribute() {
        $images = explode('|', $this->images);
        $images_url = [];
        foreach($images as $image) {
            $images_url[] = asset('Ads') . "/{$this->id}/$image";
        }
        return $images_url;
    }

    public function getIsFullAttribute() {
        $drivers_number = $this->drivers_number;
        $current_number = DriverAd::whereAdId($this->id)->whereStatus('appointement_booking')->count();
        return $drivers_number <= $current_number;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ad) {
            $ad->user_id = request()->user()->id;
        });

        static::created(function($ad) {
            $images = [];
            foreach(request('images') as $image) {
                $images[] = Files::moveFile($image, "Ads/{$ad->id}");
            }
            $ad->images = implode('|', $images);
            $ad->save();
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function drivers() {
        return $this->hasMany(DriverAd::class)->whereStatus('in_progress');
    }

    public function scopeFilter($query) {
        $region = request('region') ?? request()->user()->driver->place_of_residence;
        $query->where('regions', 'like', "%$region%");
        if(request('km_price')) {
            $query->where('km_price', '>=', request('km_price'));
        }
        return $query;
    }

    public function scopeStatus($query) {
        $query->whereStatus(request('status'));
        return $query;
    }
}
