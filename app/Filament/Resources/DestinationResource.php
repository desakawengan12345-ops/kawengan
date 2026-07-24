<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DestinationResource\Pages;
use App\Models\Destination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class DestinationResource extends Resource
{
	protected static ?string $model = Destination::class;

	protected static ?string $navigationIcon = 'heroicon-o-map-pin';

	protected static ?string $navigationLabel = 'Destinasi Wisata';

	protected static ?string $modelLabel = 'Destinasi';

	protected static ?string $pluralModelLabel = 'Destinasi Wisata';

	protected static ?string $navigationGroup = 'Konten Wisata';

	protected static ?int $navigationSort = 1;

	public static function getNavigationLabel(): string
	{
		return 'Destinasi Wisata';
	}

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Forms\Components\Section::make('Informasi Utama')
					->schema([
						Forms\Components\TextInput::make('name')
							->label('Nama Destinasi')
							->placeholder('contoh: Makam Mbah Kawengan')
							->required()
							->live(onBlur: true)
							->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
						Forms\Components\TextInput::make('slug')
							->label('Slug URL')
							->helperText('Terisi otomatis dari nama destinasi')
							->required()
							->unique(ignoreRecord: true)
							->disabled()
							->dehydrated(),
						Forms\Components\Textarea::make('description')
							->label('Deskripsi')
							->placeholder('Tuliskan deskripsi singkat tentang destinasi ini...')
							->required()
							->rows(5)
							->columnSpanFull(),
					])->columns(2),

				Forms\Components\Section::make('Foto Utama')
					->schema([
						Forms\Components\FileUpload::make('thumbnail')
							->label('Unggah Foto')
							->helperText('Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.')
							->image()
							->disk('supabase')
							->directory('destinations')
							->visibility('public')
							->downloadable()
							->openable()
							->imagePreviewHeight('200')
							->maxSize(2048),
					]),

				Forms\Components\Section::make('Lokasi')
					->schema([
						Forms\Components\Textarea::make('address')
							->label('Alamat / Petunjuk Arah')
							->placeholder('contoh: Dusun Kawengan RT 01, Desa Kawengan, Kec. ...')
							->rows(3)
							->columnSpanFull(),
						Forms\Components\Textarea::make('gmaps_embed')
							->label('Embed Google Maps')
							->placeholder('<iframe src="https://www.google.com/maps/embed?pb=..." ...></iframe>')
							->helperText('Cara mendapatkan kode embed: Buka Google Maps → Cari lokasi → Tap nama lokasi → Tap "Bagikan" → Pilih "Sematkan peta" → Salin kode HTML → Tempel di sini')
							->rows(3)
							->columnSpanFull(),
						Forms\Components\TextInput::make('gmaps_link')
							->label('Link Google Maps')
							->placeholder('https://maps.app.goo.gl/...')
							->helperText('Buka Google Maps → Cari lokasi → Tap "Bagikan" → Salin link → Tempel di sini')
							->url()
							->columnSpanFull(),
					]),

				Forms\Components\Section::make('Pengaturan')
					->schema([
						Forms\Components\Toggle::make('is_published')
							->label('Tampilkan di website')
							->helperText('Aktifkan jika destinasi ini sudah siap ditampilkan ke pengunjung')
							->default(false),
					]),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\ImageColumn::make('thumbnail')
					->label('Foto')
					->disk('supabase'),
				Tables\Columns\TextColumn::make('name')
					->label('Nama Destinasi')
					->searchable(),
				Tables\Columns\IconColumn::make('is_published')
					->label('Ditampilkan')
					->boolean(),
				Tables\Columns\TextColumn::make('created_at')
					->label('Dibuat')
					->dateTime('d M Y')
					->sortable(),
			])
			->filters([])
			->actions([
				Tables\Actions\EditAction::make()
					->label('Ubah'),
				Tables\Actions\DeleteAction::make()
					->label('Hapus'),
			])
			->bulkActions([
				Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DeleteBulkAction::make()
						->label('Hapus yang dipilih'),
				]),
			]);
	}

	public static function getRelations(): array
	{
		return [];
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListDestinations::route('/'),
			'create' => Pages\CreateDestination::route('/create'),
			'edit' => Pages\EditDestination::route('/{record}/edit'),
		];
	}
}
