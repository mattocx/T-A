<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('id') // Pakai ID untuk login
                ->label('User ID')
                ->required(),
            Forms\Components\TextInput::make('password')
                ->password()
                ->label('Password')
                ->required(),
        ];
    }
}
