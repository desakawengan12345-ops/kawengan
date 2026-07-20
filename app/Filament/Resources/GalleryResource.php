<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Galeri';

    protected static ?string $modelLabel = 'Foto Galeri';

    protected static ?string $pluralModelLabel = 'Galeri';

    protected static ?string $navigationGroup = 'Konten Wisata';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Foto')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'kegiatan' => 'Kegiatan',
                                'pemandangan' => 'Pemandangan',
                                'budaya' => 'Budaya',
                            ])
                            ->required()
                            ->default('kegiatan')
                            ->native(false)
                            ->live(),
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->helperText(function (Forms\Get $get) {
                                $category = $get('category');
                                if (!$category) return 'Pilih kategori dulu';

                                $used = Gallery::where('category', $category)
                                    ->orderBy('order')
                                    ->pluck('order')
                                    ->toArray();

                                if (empty($used)) return 'Belum ada foto untuk kategori ini';

                                $ranges = [];
                                $start = $used[0];
                                $prev = $used[0];

                                for ($i = 1; $i < count($used); $i++) {
                                    if ($used[$i] !== $prev + 1) {
                                        $ranges[] = $start === $prev ? "{$start}" : "{$start} - {$prev}";
                                        $start = $used[$i];
                                    }
                                    $prev = $used[$i];
                                }
                                $ranges[] = $start === $prev ? "{$start}" : "{$start} - {$prev}";

                                return 'Urutan terpakai: ' . implode(', ', $ranges);
                            })
                            ->unique(
                                table: Gallery::class,
                                column: 'order',
                                ignoreRecord: true,
                                modifyRuleUsing: function ($rule, Forms\Get $get) {
                                    return $rule->where('category', $get('category'));
                                }
                            )
                            ->validationMessages([
                                'unique' => 'Urutan ini sudah dipakai oleh foto lain di kategori ini.',
                            ]),
                        Forms\Components\TextInput::make('caption')
                            ->label('Keterangan Foto')
                            ->placeholder('contoh: Kegiatan bersih desa 2024')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Foto')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Unggah Foto')
                            ->helperText('Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.')
                            ->image()
                            ->disk('public')
                            ->directory('gallery')
                            ->visibility('public')
                            ->downloadable()
                            ->openable()
                            ->imagePreviewHeight('250')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'kegiatan' => 'info',
                        'pemandangan' => 'success',
                        'budaya' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'kegiatan' => 'Kegiatan',
                        'pemandangan' => 'Pemandangan',
                        'budaya' => 'Budaya',
                    }),
                Tables\Columns\TextColumn::make('caption')
                    ->label('Keterangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'kegiatan' => 'Kegiatan',
                        'pemandangan' => 'Pemandangan',
                        'budaya' => 'Budaya',
                    ])
                    ->placeholder('Semua Kategori'),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
