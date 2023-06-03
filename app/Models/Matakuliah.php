<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $table="matakuliah";
    protected $guarded=[ 
        'id',
    ];

    public function Mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class);
    }
}
