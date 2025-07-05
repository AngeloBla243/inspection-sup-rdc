<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $fillable = [
        'university_id',
        'inspector_id',
        'date',
        'objective',
        'status',
        'active',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];


    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }



    public function inspectors()
    {
        return $this->belongsToMany(\App\Models\User::class, 'inspection_user', 'inspection_id', 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(\App\Models\InspectionReport::class, 'inspection_id');
    }

    public function latestReport()
    {
        return $this->hasOne(\App\Models\InspectionReport::class, 'inspection_id')->latestOfMany();
    }
}
