<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;

    protected $table = 'announcements';

    protected $fillable = [
       'id',
       'userid',
       'description',
       'photo'
    ];

    public function User() {
        return $this->hasOne(User::class, 'id', 'userid');
    }
}
