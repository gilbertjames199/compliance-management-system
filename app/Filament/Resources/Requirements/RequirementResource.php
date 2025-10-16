<?php

namespace App\Filament\Resources\Requirements;

use App\Filament\Resources\Requirements\Pages\CreateRequirement;
use App\Filament\Resources\Requirements\Pages\EditRequirement;
use App\Filament\Resources\Requirements\Pages\ListRequirements;
use App\Filament\Resources\Requirements\Pages\ViewRequirement;
use App\Filament\Resources\Requirements\Schemas\RequirementForm;
use App\Filament\Resources\Requirements\Schemas\RequirementInfolist;
use App\Filament\Resources\Requirements\Tables\RequirementsTable;
use App\Models\Requirement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RequirementResource extends Resource
{
    protected static ?string $model = Requirement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'Requirements';

    public static function form(Schema $schema): Schema
    {
        return RequirementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RequirementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RequirementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRequirements::route('/'),
            'create' => CreateRequirement::route('/create'),
            'view' => ViewRequirement::route('/{record}'),
            'edit' => EditRequirement::route('/{record}/edit'),
        ];
    }
}
