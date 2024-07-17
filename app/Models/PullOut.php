<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PullOut extends Model
{
    use HasFactory;

    protected $table = 'pull_out';

    protected $fillable = [
       'id',
       'hte_id',
       'description',
       'file'
    ];

    public function HTE() {
        return $this->hasOne(HTE::class, 'id', 'hte_id');
    }
}
