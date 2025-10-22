<?php

namespace App\Filament\Resources\ActionDetails\Schemas;

use App\Helpers\StatusHelper;
use App\Models\ComplyingOffice;
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
                Select::make('requirement_id')
                    ->label('Requirement')
                    ->options($reqs)
                    ->required()
                    ->reactive() // 👈 makes the next field respond when this changes
                    ->afterStateUpdated(fn (callable $set) => $set('id_complying_office', null)), // reset next field

                Select::make('id_complying_office')
                    ->label('Complying Office')
                    ->searchable()
                    ->required()
                    ->options(function (callable $get) {
                        $reqId = $get('requirement_id');

                        if (! $reqId) {
                            // No requirement selected yet → disable
                            return [];
                        }

                        // Filter complying offices by requirement_id
                        return ComplyingOffice::with('office')
                            ->where('requirement_id', $reqId)
                            ->get()
                            ->mapWithKeys(function ($item) {
                                return [$item->id => optional($item->office)->office];
                            })
                            ->toArray();
                    })
                    ->disabled(fn (callable $get) => ! $get('requirement_id')), // disable until requirement is selected

                DatePicker::make('date')
                    ->required(),
                TextInput::make('action')
                    ->required(),
                Select::make('status')
                    ->options(fn () => StatusHelper::statusOptions())
                    ->required(),
                TextInput::make('mov_link')
                    ->required(),
            ]);
    }
}
