<?php

namespace App\Filament\Resources\ActionDetails\Schemas;

use App\Helpers\StatusHelper;
use App\Models\Requirement;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ActionDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        $reqs = Requirement::get()->pluck('requirement','id');
        // dd(getComplyingOffices());
        return $schema
            ->components([
                // TextInput::make('department_code')
                //     ->required(),
                Select::make('id_complying_office')
                    ->options(getComplyingOffices())
                    ->label('Complying Office')
                    ->searchable(true)
                    ->required(),

                Select::make('requirement_id')
                    ->label('Requirement')
                    ->options($reqs),
                // TextInput::make('requirement_id')
                //     ->required(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('action')
                    ->required(),
                // TextInput::make('status')
                //     ->required(),
                Select::make('status')
                    ->options(fn () => StatusHelper::statusOptions())
                    ->required(),
                TextInput::make('mov_link')
                    ->required(),
            ]);
    }
}
