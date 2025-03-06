<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Package;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('Customer ID')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(Customer ::class, 'email')
                    ->nullable(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->afterStateHydrated(fn ($state, $set) => $set('password', ''))
                    ->maxLength(255),
                TextInput::make('nik')
                    ->label('NIK')
                    ->required(),
                FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->directory('customer-photos')
                    ->nullable(),
                TextInput::make('address')
                    ->label('Alamat')
                    ->required()
                    ->maxLength(500),
                TextInput::make('phone')
                    ->label('Nomor HP')
                    ->required()
                    ->maxLength(15),
                DatePicker::make('installation_date')
                    ->label('Tanggal Pemasangan')
                    ->required(),
                Select::make('network_type')
                    ->label('Jenis Jaringan')
                    ->options([
                        'fiber' => 'Fiber Optic',
                        'wireless' => 'Wireless',
                    ])
                    ->required(),
                    Select::make('package_id')
                    ->label('Paket Internet')
                    ->options(Package::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Customer ID')->sortable(),
                TextColumn::make('name')->label('Nama')->sortable()->searchable(),
                TextColumn::make('nik')->label('NIK')->sortable()->searchable(),
                ImageColumn::make('photo')->label('Foto'),
                TextColumn::make('phone')->label('No HP')->sortable(),
                TextColumn::make('network_type')->label('Jenis Jaringan')->sortable(),
                TextColumn::make('package.name')->label('Paket Internet')->sortable(),
                TextColumn::make('installation_date')->label('Tanggal Pemasangan')->dateTime(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
