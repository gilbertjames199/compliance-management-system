<?php

namespace App\Filament\Resources\ActionDetails;

use App\Filament\Resources\ActionDetails\Pages\CreateActionDetail;
use App\Filament\Resources\ActionDetails\Pages\EditActionDetail;
use App\Filament\Resources\ActionDetails\Pages\ListActionDetails;
use App\Filament\Resources\ActionDetails\Pages\ViewActionDetail;
use App\Filament\Resources\ActionDetails\Schemas\ActionDetailForm;
use App\Filament\Resources\ActionDetails\Schemas\ActionDetailInfolist;
use App\Filament\Resources\ActionDetails\Tables\ActionDetailsTable;
use App\Models\ActionDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ActionDetailResource extends Resource
{
    protected static ?string $model = ActionDetail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowTurnRightUp;

    protected static ?string $recordTitleAttribute = 'Action Details';

    public static function form(Schema $schema): Schema
    {
        return ActionDetailForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ActionDetailInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActionDetailsTable::configure($table);
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
            'index' => ListActionDetails::route('/'),
            'create' => CreateActionDetail::route('/create'),
            'view' => ViewActionDetail::route('/{record}'),
            'edit' => EditActionDetail::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
