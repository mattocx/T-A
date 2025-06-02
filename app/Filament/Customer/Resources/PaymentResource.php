<?php

namespace App\Filament\Customer\Resources;

use App\Models\Payment;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Customer\Resources\PaymentResource\Pages;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Riwayat Pembayaran';
    protected static ?string $pluralModelLabel = 'Riwayat Pembayaran';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('order_id')->disabled(),
            Forms\Components\TextInput::make('transaction_id')->disabled(),
            Forms\Components\TextInput::make('amount')->disabled(),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'success' => 'Success',
                    'failed' => 'Failed',
                    'expired' => 'Expired',
                ])
                ->disabled(),
            Forms\Components\DateTimePicker::make('payment_date')->disabled(),
            Forms\Components\DateTimePicker::make('due_date')->disabled(),
            Forms\Components\TextInput::make('payment_method')->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('order_id'),
            Tables\Columns\TextColumn::make('amount')->money('IDR'),
            Tables\Columns\TextColumn::make('status')->badge()->colors([
                'pending' => 'warning',
                'success' => 'success',
                'failed' => 'danger',
                'expired' => 'gray',
            ]),
            Tables\Columns\TextColumn::make('payment_date')->dateTime(),
            Tables\Columns\TextColumn::make('due_date')->date(),
        ])
        ->actions([
            Action::make('download')
                ->label('Download Struk')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function (Model $record) {
                    $pdf = Pdf::loadView('pdf.payment-receipt', ['payment' => $record]);
                    return response()->streamDownload(fn () => print($pdf->output()), 'struk-' . $record->order_id . '.pdf');
                }),
        ])
        ->defaultSort('payment_date', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        // Menampilkan hanya payment milik customer yang login
        return parent::getEloquentQuery()->where('customer_id', auth()->id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
