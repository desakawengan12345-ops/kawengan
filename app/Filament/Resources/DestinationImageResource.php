<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DestinationImageResource\Pages;
use App\Models\Destination;
use App\Models\DestinationImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DestinationImageResource extends Resource
{
    protected static ?string $model = DestinationImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Foto Destinasi';

    protected static ?string $modelLabel = 'Foto Destinasi';

    protected static ?string $pluralModelLabel = 'Foto Destinasi';

    protected static ?string $navigationGroup = 'Konten Wisata';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Foto')
                    ->schema([
                        Forms\Components\Select::make('destination_id')
                            ->label('Destinasi Wisata')
                            ->options(Destination::where('is_published', false)
                                ->orWhere('is_published', true)
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->helperText('Pilih destinasi yang ingin ditambahkan fotonya'),
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText(function (Forms\Get $get) {
                                $destinationId = $get('destination_id');
                                if (!$destinationId) return 'Pilih destinasi dulu';

                                $used = DestinationImage::where('destination_id', $destinationId)
                                    ->orderBy('order')
                                    ->pluck('order')
                                    ->toArray();

                                if (empty($used)) return 'Belum ada foto untuk destinasi ini';

                                // Konversi ke format range
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
                            ->live(onBlur: true)
                            ->unique(
                                table: DestinationImage::class,
                                column: 'order',
                                ignoreRecord: true,
                                modifyRuleUsing: function ($rule, Forms\Get $get) {
                                    return $rule->where('destination_id', $get('destination_id'));
                                }
                            )
                            ->validationMessages([
                                'unique' => 'Urutan ini sudah dipakai oleh foto lain di destinasi ini.',
                            ]),
                        Forms\Components\TextInput::make('caption')
                            ->label('Keterangan Foto')
                            ->placeholder('contoh: Suasana pagi di area makam')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Foto')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Unggah Foto')
                            ->helperText('Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.')
                            ->image()
                            ->disk('public')
                            ->directory('destination-images')
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
                Tables\Columns\TextColumn::make('destination.name')
                    ->label('Destinasi')
                    ->searchable()
                    ->sortable(),
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
            ->defaultSort('destination_id')
            ->filters([
                Tables\Filters\SelectFilter::make('destination_id')
                    ->label('Destinasi')
                    ->options(Destination::pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Semua Destinasi'),
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
            'index' => Pages\ListDestinationImages::route('/'),
            'create' => Pages\CreateDestinationImage::route('/create'),
            'edit' => Pages\EditDestinationImage::route('/{record}/edit'),
        ];
    }
}
