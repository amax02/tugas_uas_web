<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tbl_barang';

    protected $fillable = [
        'id_jenis',
        'nama_barang',
        'harga',
        'stok',
        'created_at',
        'updated_at',
    ];

}


