<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $table = 'gallery';

    protected $fillable = [
        'image_path',
        'caption',
        'category',
        'order',
    ];

    protected static function booted(): void
    {
        static::updating(function (Gallery $gallery) {
            if ($gallery->isDirty('image_path') && $gallery->getOriginal('image_path')) {
                Storage::disk('supabase')->delete($gallery->getOriginal('image_path'));
            }
        });

        static::deleting(function (Gallery $gallery) {
            if ($gallery->image_path) {
                Storage::disk('supabase')->delete($gallery->image_path);
            }
        });
    }
}