<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery'; // tambah ini

    protected $fillable = [
        'image_path',
        'caption',
        'category',
        'order',
    ];
}