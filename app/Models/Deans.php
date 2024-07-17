<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deans extends Model
{
    use HasFactory;

    protected $table = 'deans';

    protected $fillable = [
       'id',
       'name',
       'address',
       'contact_number',
       'photo',
    ];

    public function User() {
        return $this->hasOne(User::class, 'dean_id', 'id');
    }
}
