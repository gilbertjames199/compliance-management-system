<?php

namespace App\Filament\Resources\ComplyingOffices\Schemas;

use App\Helpers\StatusHelper;
use App\Models\Office;
use App\Models\Requirement;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class ComplyingOfficeForm
{
    public static function configure(Schema $schema): Schema
    {
        // dd(auth()->user());

        return $schema
            ->components([
                Select::make('requirement_id')
                    ->options(getRequirements())
                    ->searchable(true)
                    ->label('Requirement')
                    ->required(),

                Select::make('department_code')
                    ->options(getOffices())
                    ->label('Department')
                    ->required()
                    ->rules(function (callable $get, $record) {
                        return [
                            Rule::unique('complying_offices', 'department_code')
                                ->where(fn ($query) => $query->where('requirement_id', $get('requirement_id')))
                                ->ignore($record?->id),
                        ];
                    })
                    ->validationMessages([
                        'unique' => 'This office already complies with the selected requirement.',
                    ]),

                Select::make('status')
                    ->options(fn () => StatusHelper::statusOptions())
                    ->required(),
                // TextInput::make('status')
            ]);
    }
}
