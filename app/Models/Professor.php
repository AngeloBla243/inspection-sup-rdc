<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $fillable = [
        'matricule',
        'name',
        'status',
        'photo'
    ];

    public function universities()
    {
        return $this->belongsToMany(University::class, 'assignments');
    }
}
