<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'coordinator_id',
        'hte_id',
        'dean_id',
        'intern_id',
        'name',
        'email',
        'password',
        'phone',
        'location',
        'about_me',
        'role',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Intern() {
        return $this->hasOne(Intern::class, 'id', 'intern_id');
    }

    public function Coordinator() {
        return $this->hasOne(Coordinators::class, 'id', 'coordinator_id');
    }

    public function HTE() {
        return $this->hasOne(HTE::class, 'id', 'hte_id');
    }

    public function Deans() {
        return $this->hasOne(Deans::class, 'id', 'dean_id');
    }

    public function Documents() {
        return $this->hasOne(Documents::class, 'intern_id', 'intern_id');
    }
    
}
