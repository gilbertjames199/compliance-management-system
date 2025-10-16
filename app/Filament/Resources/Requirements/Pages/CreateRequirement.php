<?php

namespace App\Filament\Resources\Requirements\Pages;

use App\Filament\Resources\Requirements\RequirementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRequirement extends CreateRecord
{
    protected static string $resource = RequirementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ✅ Redirects to table
    }
}
