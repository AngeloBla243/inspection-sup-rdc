<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionReport extends Model
{
    protected $fillable = [
        'inspection_id',
        'inspector_id',
        'data',
        'gps_position',
        'attachment',
        'electronic_signature',
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
