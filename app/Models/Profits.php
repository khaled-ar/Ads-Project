<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profits extends Model
{
    use HasFactory;

        /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];

    public function driver() {
        return $this->belongsTo(Driver::class)->select(['id', 'number']);
    }
}
