<?php

namespace App\Filament\Resources\ActionDetails\Pages;

use App\Filament\Resources\ActionDetails\ActionDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListActionDetails extends ListRecords
{
    protected static string $resource = ActionDetailResource::class;


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
