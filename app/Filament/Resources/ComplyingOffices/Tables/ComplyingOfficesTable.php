<?php

namespace App\Filament\Resources\ComplyingOffices\Tables;

use App\Helpers\StatusHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ComplyingOfficesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('department_code')
                //     ->searchable(),
                TextColumn::make('office.office')->label('OFFICE'),
                // TextColumn::make('requirement_id')
                //     ->searchable(),
                TextColumn::make('requirement.requirement')
                    ->label('REQUIREMENT')
                    ->searchable()->sortable(),
                TextColumn::make('status')
                    ->label('STATUS')
                    ->formatStateUsing(fn ($state) => StatusHelper::getStatusLabel($state))
                    ->badge() // optional for color styling
                    ->color(fn ($state) => match ($state) {
                        '-1' => 'danger',
                        '0'  => 'warning',
                        '1'  => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
            // ->contentGrid(['md' => 1])
            // ->extraAttributes([
            //     'class' => 'max-w-5xl mx-auto', // 👈 centers + limits width
            // ]);
    }
}
