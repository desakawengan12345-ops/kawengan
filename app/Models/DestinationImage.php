<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DestinationImage extends Model
{
    protected $fillable = [
        'destination_id',
        'image_path',
        'file_size',
        'caption',
        'order',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    protected static function booted(): void
    {
        static::saving(function (DestinationImage $image) {
            if ($image->isDirty('image_path') && $image->image_path) {
                try {
                    $image->file_size = Storage::disk('supabase')->size($image->image_path);
                } catch (\Exception $e) {
                    $image->file_size = 0;
                }
            }

            if ($image->isDirty('image_path') && !$image->image_path) {
                $image->file_size = 0;
            }
        });

        static::updating(function (DestinationImage $image) {
            if ($image->isDirty('image_path') && $image->getOriginal('image_path')) {
                Storage::disk('supabase')->delete($image->getOriginal('image_path'));
            }
        });

        static::deleting(function (DestinationImage $image) {
            if ($image->image_path) {
                Storage::disk('supabase')->delete($image->image_path);
            }
        });
    }
}