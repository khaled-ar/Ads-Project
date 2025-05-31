<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function works_days() {
        return $this->hasMany(WorksDays::class)->with('works_times');
    }

    public function appointements() {
        return $this->hasMany(Appointement::class)->with(['driver.user', 'work_day']);
    }
}
