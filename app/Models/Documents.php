<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    protected $fillable = [
       'id',
       'intern_id',
       'hte_id',
       'coordinator_id',
       'name',
       'file',
       'date',
       'type',
       'status',
       'check_document'
    ];

    public function Intern() {
        return $this->hasOne(Intern::class, 'id', 'intern_id');
    }

    public function HTE() {
        return $this->hasOne(HTE::class, 'id', 'hte_id');
    }

    public function Coordinator() {
        return $this->hasOne(Coordinator::class, 'id', 'coordinator_id');
    }

    public function Requirements() {
        return $this->hasOne(Requirements::class, 'id', 'name');
    }
}
