<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
	protected static ?string $model = Post::class;

	protected static ?string $navigationIcon = 'heroicon-o-newspaper';

	protected static ?string $navigationLabel = 'Berita';

	protected static ?string $modelLabel = 'Berita';

	protected static ?string $pluralModelLabel = 'Berita';

	protected static ?string $navigationGroup = 'Konten Wisata';

	protected static ?int $navigationSort = 4;

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Forms\Components\Section::make('Informasi Berita')
					->schema([
						Forms\Components\TextInput::make('title')
							->label('Judul Berita')
							->placeholder('contoh: Peresmian Destinasi Wisata Kawengan')
							->required()
							->live(onBlur: true)
							->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
						Forms\Components\TextInput::make('slug')
							->label('Slug URL')
							->helperText('Terisi otomatis dari judul berita')
							->required()
							->unique(ignoreRecord: true)
							->disabled()
							->dehydrated(),
						Forms\Components\Textarea::make('excerpt')
							->label('Ringkasan')
							->placeholder('Tuliskan ringkasan singkat berita ini...')
							->rows(2)
							->columnSpanFull(),
					])->columns(2),

				Forms\Components\Section::make('Thumbnail')
					->schema([
						Forms\Components\FileUpload::make('thumbnail')
							->label('Foto Berita')
							->helperText('Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.')
							->image()
							->disk('supabase')
							->directory('posts')
							->visibility('public')
							->downloadable()
							->openable()
							->imagePreviewHeight('200'),
					]),

				Forms\Components\Section::make('Konten')
					->schema([
						Forms\Components\RichEditor::make('content')
							->label('Isi Berita')
							->toolbarButtons([
								'bold', 'italic', 'underline', 'strike',
								'h2', 'h3',
								'bulletList', 'orderedList',
								'blockquote', 'link',
								'undo', 'redo',
							])
							->columnSpanFull(),
					]),

				Forms\Components\Section::make('Pengaturan')
					->schema([
						Forms\Components\Toggle::make('is_published')
							->label('Tampilkan di website')
							->helperText('Aktifkan jika berita ini sudah siap ditampilkan')
							->default(false),
						Forms\Components\DateTimePicker::make('published_at')
							->label('Tanggal Publikasi')
							->helperText('Kosongkan untuk menggunakan tanggal sekarang')
							->nullable(),
					])->columns(2),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\ImageColumn::make('thumbnail')
					->label('Foto')
					->disk('supabase'),
				Tables\Columns\TextColumn::make('title')
					->label('Judul')
					->searchable()
					->limit(40),
				Tables\Columns\TextColumn::make('excerpt')
					->label('Ringkasan')
					->limit(50)
					->toggleable(),
				Tables\Columns\IconColumn::make('is_published')
					->label('Ditampilkan')
					->boolean(),
				Tables\Columns\TextColumn::make('published_at')
					->label('Tanggal Publikasi')
					->dateTime('d M Y')
					->sortable(),
				Tables\Columns\TextColumn::make('updated_at')
					->label('Terakhir Diubah')
					->dateTime('d M Y')
					->sortable()
					->toggleable(isToggledHiddenByDefault: true),
			])
			->defaultSort('published_at', 'desc')
			->filters([
				Tables\Filters\TernaryFilter::make('is_published')
					->label('Status')
					->trueLabel('Ditampilkan')
					->falseLabel('Disembunyikan'),
			])
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
			'index' => Pages\ListPosts::route('/'),
			'create' => Pages\CreatePost::route('/create'),
			'edit' => Pages\EditPost::route('/{record}/edit'),
		];
	}
}