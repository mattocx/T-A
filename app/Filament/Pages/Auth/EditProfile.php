<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo') // Input untuk upload foto profil
                    ->image() // Hanya bisa unggah gambar
                    ->avatar() // Menampilkan dalam bentuk avatar
                    ->directory('avatars') // Menyimpan ke storage/avatars
                    ->maxSize(1024) // Maksimal 1MB
                    ->nullable(), // Tidak wajib diisi

                TextInput::make('phone')
                    ->nullable()
                    ->maxLength(255),

                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
