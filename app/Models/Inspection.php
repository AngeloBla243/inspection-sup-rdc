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

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function reports()
    {
        return $this->hasMany(InspectionReport::class);
    }
}
