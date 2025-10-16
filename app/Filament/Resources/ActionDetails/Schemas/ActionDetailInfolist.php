<?php

namespace App\Filament\Resources\ActionDetails\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ActionDetailInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('department_code'),
                // TextEntry::make('office.name')
                //     ->label('Office')
                //     ->placeholder('-'),
                TextEntry::make('requirement.requirement')
                    ->label('Requirement')
                    ->placeholder('-'),
                // TextEntry::make('requirement_id'),
                TextEntry::make('date'),
                TextEntry::make('action'),
                TextEntry::make('status')
                ->formatStateUsing(fn ($state) => match ((string) $state) {
                    '-1' => 'Not Complied',
                    '0' => 'Partially Complied',
                    '1' => 'Complied',
                    default => 'Unknown',
                }),
                TextEntry::make('mov_link'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
