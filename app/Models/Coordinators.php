<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinators extends Model
{
    use HasFactory;

    protected $table = 'coordinators';

    protected $fillable = [
       'id',
       'name',
       'address',
       'contact_number',
       'photo',
       'status'
    ];

    public function User() {
        return $this->hasOne(User::class, 'coordinator_id', 'id');
    }
}
