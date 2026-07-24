<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'thumbnail_size',
        'address',
        'gmaps_embed',
        'gmaps_link',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(DestinationImage::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Destination $destination) {
            if ($destination->isDirty('thumbnail') && $destination->thumbnail) {
                try {
                    $destination->thumbnail_size = Storage::disk('supabase')->size($destination->thumbnail);
                } catch (\Exception $e) {
                    $destination->thumbnail_size = 0;
                }
            }

            if ($destination->isDirty('thumbnail') && !$destination->thumbnail) {
                $destination->thumbnail_size = 0;
            }
        });

        static::updating(function (Destination $destination) {
            if ($destination->isDirty('thumbnail') && $destination->getOriginal('thumbnail')) {
                Storage::disk('supabase')->delete($destination->getOriginal('thumbnail'));
            }
        });

        static::deleting(function (Destination $destination) {
            if ($destination->thumbnail) {
                Storage::disk('supabase')->delete($destination->thumbnail);
            }

            foreach ($destination->images as $image) {
                Storage::disk('supabase')->delete($image->image_path);
            }
        });
    }
}