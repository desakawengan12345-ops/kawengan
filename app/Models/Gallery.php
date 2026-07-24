<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $table = 'gallery';

    protected $fillable = [
        'image_path',
        'file_size',
        'caption',
        'category',
        'order',
    ];

    protected static function booted(): void
    {
        static::saving(function (Gallery $gallery) {
            if ($gallery->isDirty('image_path') && $gallery->image_path) {
                try {
                    $gallery->file_size = Storage::disk('supabase')->size($gallery->image_path);
                } catch (\Exception $e) {
                    $gallery->file_size = 0;
                }
            }

            if ($gallery->isDirty('image_path') && !$gallery->image_path) {
                $gallery->file_size = 0;
            }
        });

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