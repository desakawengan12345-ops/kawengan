<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'excerpt',
        'content',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updating(function (Post $post) {
            if ($post->isDirty('thumbnail') && $post->getOriginal('thumbnail')) {
                Storage::disk('supabase')->delete($post->getOriginal('thumbnail'));
            }
        });

        static::deleting(function (Post $post) {
            if ($post->thumbnail) {
                Storage::disk('supabase')->delete($post->thumbnail);
            }
        });
    }
}