<?php

namespace App\Filament\Resources\ActionDetails\Pages;

use App\Filament\Resources\ActionDetails\ActionDetailResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewActionDetail extends ViewRecord
{
    protected static string $resource = ActionDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
