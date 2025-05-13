<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\RichEditor;
use Saade\FilamentMoney\Forms\Components\Money;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static ?string $navigationGroup = 'Manajemen Paket';
    protected static ?string $navigationIcon = 'heroicon-o-wifi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Paket')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Paket')
                            ->required(),

                            TextInput::make('price')
                            ->label('Harga Paket')
                            ->prefix('Rp') // Tambahkan Rp di depan input
                            ->numeric() // Pastikan hanya angka yang bisa dimasukkan
                            ->required(),


                        TextInput::make('duration')
                            ->label('Masa Aktif (Hari)')
                            ->numeric()
                            ->default(30)
                            ->required(),

                        RichEditor::make('description')
                            ->label('Keterangan')
                            ->toolbarButtons([
                                'attachFiles', 'blockquote', 'bold', 'bulletList', 'codeBlock',
                                'h2', 'h3', 'italic', 'link', 'orderedList', 'redo',
                                'strike', 'underline', 'undo',
                            ])
                            ->columnSpanFull()
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Paket')->sortable(),
                TextColumn::make('price')
    ->label('Harga')
    ->formatStateUsing(fn (string $state): string => 'Rp. ' . number_format((float) $state, 0, ',', '.'))
    ->sortable(),

                TextColumn::make('duration')->label('Masa Aktif')->sortable(),
                TextColumn::make('description')->label('Keterangan')->limit(50),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
