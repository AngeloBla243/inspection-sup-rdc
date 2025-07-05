<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'name',
        'type',
        'location',
        'agreement',
        'professors_count',
        'gps_latitude',
        'gps_longitude',
        'inspection_status',
        'logo'
    ];

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'assignments');
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }
}
