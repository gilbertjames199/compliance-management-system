<?php

namespace App\Filament\Resources\ActionDetails\Pages;

use App\Filament\Resources\ActionDetails\ActionDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditActionDetail extends EditRecord
{
    protected static string $resource = ActionDetailResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ✅ Redirects to table
    }
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
