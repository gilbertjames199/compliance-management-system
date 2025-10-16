<?php

namespace App\Filament\Resources\ActionDetails\Tables;

use App\Helpers\StatusHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActionDetailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('action')
                    ->searchable(),
                TextColumn::make('office.short_name')
                    ->searchable(),
                TextColumn::make('requirement.requirement')
                    ->searchable(),
                // TextColumn::make('date')
                //     ->searchable(),

                // TextColumn::make('status')
                //     ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => StatusHelper::getStatusLabel($state))
                    ->badge() // optional for color styling
                    ->color(fn ($state) => match ($state) {
                        '-1' => 'danger',
                        '0'  => 'warning',
                        '1'  => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('mov_link')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
