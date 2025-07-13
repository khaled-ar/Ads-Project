<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Files;

class Story extends Model
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
        'image'
    ];

    protected $appends = ['image_url'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($story) {
            $story->image = Files::moveFile(request('image'), "Stories/{$story->id}");
            $story->save();
        });
    }

    public function getImageUrlAttribute() {
        return asset('Stories') . "/{$this->id}/$this->image";
    }
}
