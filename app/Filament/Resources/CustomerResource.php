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
use App\Exports\CustomerExport;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Helpers\Fonnte;
use Filament\Notifications\Notification;

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
                TextInput::make('id')->label('Customer ID')->disabled()->dehydrated(),
                TextInput::make('name')->label('Nama')->required()->maxLength(255),
                TextInput::make('username')->label('Username'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->afterStateHydrated(fn ($state, $set) => $set('password', ''))
                    ->maxLength(255),
                TextInput::make('nik')->label('NIK')->required(),
                FileUpload::make('photo')->label('Foto')->image()->directory('customer-photos')->nullable(),
                TextInput::make('address')->label('Alamat')->required()->maxLength(500),
                TextInput::make('phone')->label('Nomor HP')->required()->maxLength(15),
                DatePicker::make('installation_date')->label('Tanggal Pemasangan')->required(),
                Select::make('network_type')
                    ->label('Jenis Jaringan')
                    ->options([
                        'Fiber' => 'Fiber Optic',
                        'Wireless' => 'Wireless',
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
            ->headerActions([
                Action::make('import')
                    ->label('Impor Customer')
                    ->icon('heroicon-o-document-arrow-up')
                    ->form([
                        FileUpload::make('file')
                            ->label('Pilih File Excel')
                            ->disk('public')
                            ->directory('temp')
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-excel',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $path = Storage::disk('public')->path($data['file']);
                        Excel::import(new CustomerImport, $path);
                    }),

                Action::make('export')
                    ->label('Ekspor Customer')
                    ->icon('heroicon-o-document-arrow-down')
                    ->form([
                        Select::make('format')
                            ->label('Pilih Format')
                            ->options([
                                'excel' => 'Excel (.xlsx)',
                                'pdf' => 'PDF (.pdf)',
                            ])
                            ->required(),
                        Select::make('status')
                            ->label('Filter Status')
                            ->options([
                                'all' => 'Semua',
                                'active' => 'Aktif',
                                'inactive' => 'Nonaktif',
                                'overdue' => 'Menunggak',
                            ])
                            ->default('all')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $status = $data['status'];
                        $format = $data['format'];

                        $query = Customer::query();

                        if ($status === 'active' || $status === 'inactive') {
                            $query->where('status', $status);
                        } elseif ($status === 'overdue') {
                            $query->whereHas('payments', function ($q) {
                                $q->where('status', '!=', 'success')
                                  ->whereDate('due_date', '<', now());
                            });
                        }

                        $customers = $query->get();

                        if ($format === 'excel') {
                            return Excel::download(new CustomerExport($customers), 'customers.xlsx');
                        } else {
                            $pdf = Pdf::loadView('exports.customers', [
                                'customers' => $customers,
                            ]);
                            return response()->streamDownload(
                                fn () => print($pdf->stream()),
                                'customers.pdf'
                            );
                        }
                    }),

                // ✅ Broadcast WhatsApp di Header
                Action::make('broadcast_whatsapp')
                    ->label('Broadcast WhatsApp')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->label('Isi Pesan')
                            ->placeholder('Halo {{name}}, ini adalah pesan broadcast.')
                            ->rows(4)
                            ->required(),

                        Select::make('status')
                            ->label('Filter Status Pelanggan')
                            ->options([
                                'active' => 'Aktif',
                                'inactive' => 'Nonaktif',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $messageTemplate = $data['message'];
                        $status = $data['status'];

                        $customers = Customer::where('status', $status)->get();

                        $sukses = 0;
                        $gagal = 0;
                        $nomorGagal = [];

                        foreach ($customers as $customer) {
                            $message = str_replace('{{name}}', $customer->name, $messageTemplate);
                            $response = Fonnte::send($customer->phone, $message);

                            if (isset($response['status']) && $response['status'] === true) {
                                $sukses++;
                            } else {
                                $gagal++;
                                $nomorGagal[] = $customer->phone;
                            }
                        }

                        Notification::make()
                            ->title("Broadcast selesai: {$sukses} sukses, {$gagal} gagal")
                            ->body($gagal > 0 ? 'Nomor gagal: ' . implode(', ', $nomorGagal) : 'Semua pesan terkirim.')
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Broadcast WhatsApp')
                    ->modalDescription('Kirim pesan WhatsApp ke semua pelanggan berdasarkan status mereka.')
                    ->requiresConfirmation(),
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
                Action::make('send_whatsapp')
                    ->label('Kirim WhatsApp')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->label('Pesan WhatsApp')
                            ->default('Halo {{name}}, paket internet Anda sudah nonaktif. Segera lakukan pembayaran untuk paket {{package.name}} seharga Rp{{package.price}}. Terima kasih!')
                            ->required(),
                    ])
                    ->action(function (array $data, $record) {
                        $message = $data['message'];

                        $message = str_replace('{{name}}', $record->name, $message);
                        $message = str_replace('{{package.name}}', $record->package->name ?? '-', $message);
                        $message = str_replace('{{package.price}}', number_format($record->package->price ?? 0, 0, ',', '.'), $message);


                        $result = Fonnte::send($record->phone, $message);

                        if (isset($result['status']) && $result['status'] == true) {
                            Notification::make()
                                ->title('Pesan berhasil dikirim ke ' . $record->phone)
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Gagal mengirim pesan')
                                ->body($result['reason'] ?? 'Cek kembali token dan nomor tujuan.')
                                ->danger()
                                ->send();
                        }
                    }),
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
