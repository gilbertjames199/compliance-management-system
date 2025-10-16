<?php

namespace App\Filament\Resources\ComplyingOffices\Pages;

use App\Filament\Resources\ComplyingOffices\ComplyingOfficeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComplyingOffice extends CreateRecord
{
    protected static string $resource = ComplyingOfficeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ✅ Redirects to table
    }
}
