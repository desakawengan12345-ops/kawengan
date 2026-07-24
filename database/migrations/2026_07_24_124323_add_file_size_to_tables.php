<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->unsignedBigInteger('thumbnail_size')->default(0)->after('thumbnail');
        });

        Schema::table('destination_images', function (Blueprint $table) {
            $table->unsignedBigInteger('file_size')->default(0)->after('image_path');
        });

        Schema::table('gallery', function (Blueprint $table) {
            $table->unsignedBigInteger('file_size')->default(0)->after('image_path');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('thumbnail_size')->default(0)->after('thumbnail');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', fn($t) => $t->dropColumn('thumbnail_size'));
        Schema::table('destination_images', fn($t) => $t->dropColumn('file_size'));
        Schema::table('gallery', fn($t) => $t->dropColumn('file_size'));
        Schema::table('posts', fn($t) => $t->dropColumn('thumbnail_size'));
    }
};