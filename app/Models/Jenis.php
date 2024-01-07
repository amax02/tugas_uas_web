<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'tbl_jenis_barang';

    protected $fillable = [
        'nama_jenis',
        'created_at',
        'updated_at',
    ];

}


