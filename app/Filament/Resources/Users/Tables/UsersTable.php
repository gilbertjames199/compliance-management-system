<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('NAME'),

                TextColumn::make('email')
                    ->label('EMAIL ADDRESS')
                    ->searchable(),
                TextColumn::make('userEmployees.office.short_name')->label('OFFICE'),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('office')
                    ->label('Office')
                    ->options(function () {
                        return \App\Models\Office::on('mysql2')
                            ->orderBy('short_name')
                            ->pluck('short_name', 'department_code')
                            ->toArray();
                    })
                    ->multiple()
                    ->searchable()
                    ->query(function ($query, $data) {
                        if (!empty($data['values'])) {
                            // 🔹 Fetch employee IDs from mysql3 based on selected offices (department codes)
                            $emplIds = \App\Models\UserEmployee::on('mysql3')
                                ->whereHas('office', function ($q) use ($data) {
                                    $q->whereIn('department_code', $data['values']);
                                })
                                ->pluck('empl_id')
                                ->toArray();

                            // 🔹 Filter users whose cats_number matches the fetched employee IDs
                            $query->whereIn('cats_number', $emplIds);
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
