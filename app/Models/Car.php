<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * The attributes that not are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function years() {
        return $this->hasMany(CarsYears::class);
    }
}
