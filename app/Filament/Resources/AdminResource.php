<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Hash;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('Admin ID')
                    ->disabled()
                    ->dehydrated(),

                TextInput::make('name')
                    ->label('Nama Admin')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->maxLength(15)
                    ->nullable(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(Admin::class, 'email')
                    ->nullable(),

                FileUpload::make('photo')
                    ->label('Foto Profil')
                    ->image()
                    ->avatar()
                    ->directory('admin-photos')
                    ->nullable(),

                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->afterStateHydrated(fn ($state, $set) => $set('password', ''))
                    ->maxLength(255),

                    TextInput::make('role')
    ->label('Role')
    ->default('admin')
    ->disabled(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular() // Membuat foto berbentuk bulat
                    ->square(), // Memastikan ukuran tetap persegi
                TextColumn::make('id')->label('Admin ID')->sortable(),
                TextColumn::make('name')->label('Nama Admin')->sortable()->searchable(),
                TextColumn::make('phone')->label('Nomor Telepon')->sortable()->searchable(),
                TextColumn::make('email')->label('Email')->sortable()->searchable(),
                TextColumn::make('role')
    ->label('Role')
    ->formatStateUsing(fn () => 'Admin') // Menampilkan "Admin" secara default
    ->sortable(),

                TextColumn::make('created_at')->label('Dibuat Pada')->dateTime(),
            ])
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
