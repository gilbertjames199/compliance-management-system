<?php

namespace App\Filament\Resources\ActionDetails\Pages;

use App\Filament\Resources\ActionDetails\ActionDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateActionDetail extends CreateRecord
{
    protected static string $resource = ActionDetailResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ✅ Redirects to table
    }
}
