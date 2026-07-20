<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Beranda
            ['key' => 'hero_title',       'value' => 'Selamat Datang di Desa Kawengan'],
            ['key' => 'hero_subtitle',    'value' => 'Jelajahi keindahan dan budaya desa kami'],
            ['key' => 'hero_image',       'value' => ''],

            // Profil Desa
            ['key' => 'about_title',      'value' => 'Tentang Desa Kawengan'],
            ['key' => 'about_content',    'value' => 'Isi profil desa di sini...'],

            // Sejarah
            ['key' => 'history_title',    'value' => 'Sejarah Desa'],
            ['key' => 'history_content',  'value' => 'Isi sejarah desa di sini...'],

            // Kontak
            ['key' => 'contact_phone',    'value' => ''],
            ['key' => 'contact_email',    'value' => ''],
            ['key' => 'contact_address',  'value' => ''],
            ['key' => 'contact_gmaps',    'value' => ''],

            // Media Sosial
            ['key' => 'social_instagram', 'value' => ''],
            ['key' => 'social_facebook',  'value' => ''],
            ['key' => 'feature_news', 'value' => '1'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}