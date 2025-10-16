<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\UserEmployee;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        $users = UserEmployee::when(!in_array(auth()->user()->department_code, ['25', '26']), function ($query) {
                $query->where('department_code', auth()->user()->department_code);
            })
            ->get()
            ->pluck('employee_name','empl_id');
        // dd($users[8510]);
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('User Information')
                            ->schema([
                                Select::make('cats_number')
                                    ->options($users)
                                    ->searchable(true)
                                    ->required()
                                    ->reactive() // make it reactive
                                    ->afterStateUpdated(function ($state, callable $set) use ($users) {
                                        // when cats_number is selected, update the name
                                        $employee = UserEmployee::where('empl_id', $state)->first();
                                        if ($employee) {
                                            $set('name', $employee->employee_name);
                                        }
                                    }),
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->required(),
                                DateTimePicker::make('email_verified_at'),
                                // TextInput::make('cats_number')
                                //     ->required(),
                                Select::make('department_code')
                                    ->options(getOffices())
                                    ->searchable(true)
                                    ->required(),
                            ])
                            ->columns(1) // optional: two-column layout inside this section
                            ->columnSpan(1) // take half width of the form
                            ->extraAttributes(['class' => 'flex-1 h-full']),
                        Section::make('User Credentials')
                            ->schema([
                                TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->rule('confirmed') // ensures it matches confirm password
                                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)) // hash before save
                                    ->same('password_confirmation') // optional double check
                                    ->helperText('Passwords must match.')
                                    ->label('Password'),

                                // 🔒 Confirm Password field
                                TextInput::make('password_confirmation')
                                    ->password()
                                    ->required()
                                    ->label('Confirm Password')
                                    ->same('password') // ensure match (client-side)
                                    ->helperText('Please re-enter your password.'),
                            ])
                            ->columns(1)
                            ->columnSpan(1) // take half width of the form
                            ->extraAttributes(['class' => 'flex-1 h-full']),
                    ])->extraAttributes(['class' => 'flex gap-4 h-full'])

            ]);
    }
}
