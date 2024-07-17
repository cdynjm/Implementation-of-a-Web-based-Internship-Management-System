<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;

    protected $table = 'intern';

    protected $fillable = [
       'id',
       'name',
       'studentid',
       'address',
       'contact_number',
       'birthdate',
       'gender',
       'course',
       'major',
       'year',
       'coordinator',
       'hte',
       'photo',
       'valid_id',
       'status',
       'training_status'
    ];

    public function User() {
        return $this->hasOne(User::class, 'intern_id', 'id');
    }

    public function HTE() {
        return $this->hasOne(HTE::class, 'id', 'hte');
    }

    public function Coordinator() {
        return $this->hasOne(Coordinators::class, 'id', 'coordinator');
    }
}
