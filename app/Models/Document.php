<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
        'file',
        'type',
        'professor_id',
        'university_id',
        'inspection_id'
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
