<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
   protected $table = 'tbl_diskon';

    protected $fillable = [
        'id',
        'total_belanja',
        'diskon',
        'created_at',
        'updated_at',
    ];
}