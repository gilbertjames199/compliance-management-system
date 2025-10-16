<?php

namespace App\Filament\Resources\Requirements\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RequirementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        // dd("diri ang red only");
        return $schema
            ->components([
                TextEntry::make('requirement')->label('Requirement'),
                TextEntry::make('date_created'),
                // TextEntry::make('requiring_agency'),
                TextEntry::make('office.office')
                    ->label('Office')
                    ->placeholder('-'),
                // TextEntry::make('within'),
                TextEntry::make('due_date'),
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ]);
    }
}
