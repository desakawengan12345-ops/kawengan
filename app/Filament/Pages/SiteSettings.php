<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Pengaturan Website';

    protected static ?string $title = 'Pengaturan Website';

    protected static string $view = 'filament.pages.site-settings';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Beranda')
                    ->schema([
                        Forms\Components\TextInput::make('hero_title')
                            ->label('Judul Utama')
                            ->placeholder('contoh: Selamat Datang di Desa Kawengan')
                            ->required(),
                        Forms\Components\TextInput::make('hero_subtitle')
                            ->label('Tagline / Subjudul')
                            ->placeholder('contoh: Jelajahi keindahan dan budaya desa kami'),
                        Forms\Components\FileUpload::make('hero_image')
                            ->label('Foto Hero')
                            ->helperText('Foto background halaman utama. Format: JPG, PNG. Maksimal 2MB.')
                            ->image()
                            ->disk('supabase')
                            ->directory('settings')
                            ->visibility('public')
                            ->downloadable()
                            ->openable()
                            ->imagePreviewHeight('200')
                            ->columnSpanFull()
                            ->maxSize(2048),
                    ])->columns(2),

                Forms\Components\Section::make('Profil Desa')
                    ->schema([
                        Forms\Components\TextInput::make('about_title')
                            ->label('Judul Section')
                            ->required(),
                        Forms\Components\RichEditor::make('about_content')
                            ->label('Isi Profil Desa')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'link',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Sejarah Desa')
                    ->schema([
                        Forms\Components\TextInput::make('history_title')
                            ->label('Judul Section')
                            ->required(),
                        Forms\Components\RichEditor::make('history_content')
                            ->label('Isi Sejarah Desa')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'link',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Nomor HP / WhatsApp')
                            ->placeholder('contoh: 08123456789')
                            ->tel(),
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email')
                            ->placeholder('contoh: pokdarwis@gmail.com')
                            ->email(),
                        Forms\Components\Textarea::make('contact_address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('contact_gmaps')
                            ->label('Embed Google Maps')
                            ->placeholder('<iframe src="https://www.google.com/maps/embed?pb=..." ...></iframe>')
                            ->helperText('Buka Google Maps → Cari lokasi → Tap "Bagikan" → Pilih "Sematkan peta" → Salin kode HTML → Tempel di sini')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('social_instagram')
                            ->label('Instagram')
                            ->placeholder('contoh: https://instagram.com/desawisatakawengan')
                            ->url()
                            ->prefixIcon('heroicon-o-globe-alt'),
                        Forms\Components\TextInput::make('social_facebook')
                            ->label('Facebook')
                            ->placeholder('contoh: https://facebook.com/desawisatakawengan')
                            ->url()
                            ->prefixIcon('heroicon-o-globe-alt'),
                    ])->columns(2),

                Forms\Components\Section::make('Fitur Website')
                    ->schema([
                        Forms\Components\Toggle::make('feature_news')
                            ->label('Aktifkan Fitur Berita')
                            ->helperText('Nonaktifkan jika berita tidak rutin diupdate')
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->default(true),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $fileFields = ['hero_image'];

        foreach ($fileFields as $field) {
            if (isset($data[$field])) {
                $oldValue = SiteSetting::where('key', $field)->value('value');

                if ($oldValue && $oldValue !== $data[$field]) {
                    Storage::disk('supabase')->delete($oldValue);
                }

                // Simpan ukuran file
                $fileSize = 0;
                if (!empty($data[$field])) {
                    try {
                        $fileSize = Storage::disk('supabase')->size($data[$field]);
                    } catch (\Exception $e) {
                        $fileSize = 0;
                    }
                }
                $data[$field . '_size'] = $fileSize;
            }
        }

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan!')
            ->success()
            ->send();
    }
}
