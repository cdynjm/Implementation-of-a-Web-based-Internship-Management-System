<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    use HasFactory;

    protected $table = 'termination';

    protected $fillable = [
       'id',
       'intern_id',
    ];

    public function Intern() {
        return $this->hasOne(Intern::class, 'id', 'intern_id');
    }
}
