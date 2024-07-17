<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HTE extends Model
{
    use HasFactory;

    protected $table = 'hte';

    protected $fillable = [
       'id',
       'name',
       'address',
       'contact_number',
       'photo',
       'status',
       'slot',
       'contact_person'
    ];

    public function User() {
        return $this->hasOne(User::class, 'hte_id', 'id');
    }
}
