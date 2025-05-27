<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorksDays extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function works_times() {
        return $this->hasMany(WorksTimes::class);
    }
}
