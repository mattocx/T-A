<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesResource\Pages;
use App\Filament\Resources\SalesResource\RelationManagers;
use App\Models\Sales;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;


class SalesResource extends Resource
{
    protected static ?string $model = Sales::class;

    protected static ?string $navigationLabel = 'Sales';
    protected static ?string $slug = 'sales';
    protected static ?string $navigationGroup = 'Pengguna';
     protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                ->label('Sales ID')
                ->disabled()
                ->dehydrated(),
                TextInput::make('name')
                    ->label('Nama Sales')
                    ->required()
                    ->maxLength(255),

                    FileUpload::make('photo')
                    ->label('Foto Profil')
                    ->image()
                    ->avatar()
                    ->directory('sales-photos')
                    ->nullable(),

                    TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->afterStateHydrated(fn ($state, $set) => $set('password', ''))
                    ->maxLength(255),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
        ->columns([
            ImageColumn::make('photo')
                ->label('Foto')
                ->circular()
                ->square(),
            TextColumn::make('id')->label('Sales ID')->sortable(),
            TextColumn::make('name')->label('Nama Sales')->sortable()->searchable(),
            TextColumn::make('phone')->label('Nomor Telepon')->sortable()->searchable(),
            TextColumn::make('created_at')->label('Dibuat Pada')->dateTime(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSales::route('/create'),
            'edit' => Pages\EditSales::route('/{record}/edit'),
        ];
    }
}
