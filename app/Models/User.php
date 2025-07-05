<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'profile_picture',
        'status',
        'last_login_latitude',
        'last_login_longitude',
        // autres colonnes selon votre table
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture
            ? asset('storage/' . $this->profile_picture)
            : asset('images/default-avatar.png'); // chemin vers une image par défaut
    }

    // public function inspections()
    // {
    //     return $this->hasMany(\App\Models\Inspection::class, 'inspector_id');
    // }

    public function inspections()
    {
        return $this->belongsToMany(\App\Models\Inspection::class, 'inspection_user', 'user_id', 'inspection_id');
    }
}
