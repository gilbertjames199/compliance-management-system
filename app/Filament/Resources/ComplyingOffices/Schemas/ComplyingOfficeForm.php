<?php

namespace App\Filament\Resources\ComplyingOffices\Schemas;

use App\Helpers\StatusHelper;
use App\Models\Office;
use App\Models\Requirement;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ComplyingOfficeForm
{
    public static function configure(Schema $schema): Schema
    {
        // dd(auth()->user());

        return $schema
            ->components([
                Select::make('department_code')
                    ->options(getOffices())
                    ->label('Department')
                    ->required(),

                // TextInput::make('requirement_id')
                //     ->required(),
                Select::make('requirement_id')
                    ->options(getRequirements())
                    ->searchable(true)
                    ->label('Requirement')
                    ->required(),
                Select::make('status')
                    ->options(fn () => StatusHelper::statusOptions())
                    ->required(),
                // TextInput::make('status')
            ]);
    }
}
