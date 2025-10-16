<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->autofocus(),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable(),
            ]);
    }

    protected function attemptLogin(array $data): bool
    {
        return Auth::attempt([
            'username' => $data['username'],
            'password' => $data['password'],
        ], $this->remember());
    }
}
