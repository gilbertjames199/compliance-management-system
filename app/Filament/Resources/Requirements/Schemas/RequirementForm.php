<?php

namespace App\Filament\Resources\Requirements\Schemas;

use App\Models\Office;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RequirementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date_created')
                    ->required(),
                // Select::make('within')
                //     ->label('Agency is within the Provincial Capitol')
                //     ->options([
                //         '0' =>'No',
                //         '1' =>'Yes'
                //     ]),
                Select::make('requiring_agency')
                    ->label('Requiring Agency')
                    ->options(getOffices())
                    ->searchable()
                    ->required(),
                DatePicker::make('due_date')
                    ->required(),
                TextInput::make('requirement')
                    ->required()
            ]);
    }
}
