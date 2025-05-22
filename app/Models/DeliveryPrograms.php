<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPrograms extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that not are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
}
