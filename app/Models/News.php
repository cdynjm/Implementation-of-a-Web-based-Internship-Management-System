<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
       'id',
       'hte_id',
       'description',
       'photo'
    ];

    public function HTE() {
        return $this->hasOne(HTE::class, 'id', 'hte_id');
    }
}
