<?php
namespace App\Filament\Pages;

use Filament\Pages\Auth\Login;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginCustom extends Login
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id') // Ganti dari email ke user_id
                    ->label('User ID')
                    ->required()
                    ->autocomplete(),

                TextInput::make('password')
                    ->password()
                    ->label('Password')
                    ->required(),

                Checkbox::make('remember')
                    ->label(__('Remember me')),
            ]);
    }

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();
        $guards = ['admin', 'sales', 'customer'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt([
                'id' => $data['id'],
                'password' => $data['password'],
            ], $data['remember'] ?? false)) {
                Auth::shouldUse($guard); // set guard yang berhasil
                session()->regenerate();

                return app(LoginResponse::class);
            }
        }

        throw ValidationException::withMessages([
            'id' => __('User ID atau Password salah.'),
        ]);
    }
}
