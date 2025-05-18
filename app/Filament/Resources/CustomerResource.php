<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use App\Models\Package;
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
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomerImport;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Pengguna';
    protected static ?string $recordTitleAttribute = 'name';

    public static function canGloballySearch(): bool
    {
        return true;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'nik', 'address'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'NIK' => $record->nik,
            'Alamat' => $record->address,
            'No HP' => $record->phone,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('Customer ID')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('name')->label('Nama')->required()->maxLength(255),
                TextInput::make('username')->label('username'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->afterStateHydrated(fn ($state, $set) => $set('password', ''))
                    ->maxLength(255),
                TextInput::make('nik')->label('NIK')->required(),
                FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->directory('customer-photos')
                    ->nullable(),
                TextInput::make('address')->label('Alamat')->required()->maxLength(500),
                TextInput::make('phone')->label('Nomor HP')->required()->maxLength(15),
                DatePicker::make('installation_date')->label('Tanggal Pemasangan')->required(),
                Select::make('network_type')
                    ->label('Jenis Jaringan')
                    ->options([
                        'fiber' => 'Fiber Optic',
                        'wireless' => 'Wireless',
                    ])
                    ->required(),
                Select::make('package_id')
                    ->label('Paket Internet')
                    ->options(fn () => Package::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Nonaktif',
                    ])
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
                TextColumn::make('installation_date')->label('Tanggal Pemasangan')->date(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->formatStateUsing(fn ($state) => $state === 'active' ? 'Aktif' : 'Nonaktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('toggle_status')
                    ->label(fn ($record) => $record->status === 'active' ? 'Nonaktifkan' : 'Aktifkan')
                    ->icon(fn ($record) => $record->status === 'active' ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->status === 'active' ? 'danger' : 'success')
                    ->visible(fn () => Auth::guard('admin')->check())
                    ->action(fn ($record) => $record->update([
                        'status' => $record->status === 'active' ? 'inactive' : 'active',
                    ])),
                Action::make('import')
                    ->label('Impor Customer')
                    ->icon('heroicon-o-document-arrow-up')
                    ->form([
                        FileUpload::make('file')
                            ->label('Pilih File Excel')
                            ->disk('public') // Gunakan disk 'public'
                            ->directory('temp') // simpan di storage/app/public/temp
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-excel',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $path = Storage::disk('public')->path($data['file']);
                        Excel::import(new CustomerImport, $path);
                    })
                    ->color('primary')
                    ->modalHeading('Import Data Customer')
                    ->modalDescription('Unggah file Excel berformat .xlsx untuk menambahkan data customer.'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
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
