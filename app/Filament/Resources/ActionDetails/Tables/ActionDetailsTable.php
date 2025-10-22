<?php

namespace App\Filament\Resources\ActionDetails\Tables;

use App\Helpers\StatusHelper;
use App\Models\ComplyingOffice;
use App\Models\Office;
use App\Models\Requirement;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActionDetailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('action')
                    ->searchable()
                    ->sortable()
                    ->label('ACTION'),
                TextColumn::make('complying_office.office.short_name')->sortable()->label('OFFICE'),
                TextColumn::make('requirement.requirement')->sortable()->label('REQUIREMENT'),
                // TextColumn::make('date')
                //     ->searchable(),

                // TextColumn::make('status')
                //     ->searchable(),
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
                TextColumn::make('mov_link')
                    ->searchable()
                    ->label('MOV LINK'),
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
                /** ✅ 1. STATUS FILTER **/
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        '-1' => 'Not Complied',
                        '0'  => 'Partially Complied',
                        '1'  => 'Complied',
                    ])
                    ->multiple() // allow selecting multiple statuses
                    ->query(function ($query, $data) {
                        if (! empty($data['values'])) {
                            $query->whereIn('status', $data['values']);
                        }
                    }),

                /** ✅ 2. OFFICE FILTER **/
                // SelectFilter::make('department_code')
                //     ->label('Office')
                //     ->options(Office::query()
                //         ->pluck('short_name', 'department_code')
                //         ->toArray()
                //     )
                //     ->multiple()
                //     ->searchable()
                //     ->query(function ($query, $data) {
                //         if (! empty($data['values'])) {
                //             $query->whereIn('department_code', $data['values']);
                //         }
                //     }),
                SelectFilter::make('complying_office_id')
                    ->label('Office')
                    ->options(function () {
                        return ComplyingOffice::with('office')
                            ->get()
                            ->filter(fn ($co) => $co->office) // ensure related Office exists
                            ->mapWithKeys(fn ($co) => [
                                $co->id => $co->office->short_name,
                            ])
                            ->toArray();
                    })
                    ->multiple()
                    ->searchable()
                    ->query(fn ($query, $data) =>
                        ! empty($data['values'])
                            ? $query->whereIn('id_complying_office', $data['values'])
                            : null
                    ),

                /** ✅ 3. REQUIREMENT FILTER **/
                SelectFilter::make('requirement_id')
                    ->label('Requirement')
                    ->options(Requirement::query()
                        ->pluck('requirement', 'id')
                        ->toArray()
                    )
                    ->multiple()
                    ->searchable()
                    ->query(function ($query, $data) {
                        if (! empty($data['values'])) {
                            $query->whereIn('requirement_id', $data['values']);
                        }
                    }),
                /** 🆕 4. REQUIRING AGENCY FILTER (via Requirement -> Office) **/
                SelectFilter::make('requiring_agency')
                    ->label('Requiring Agency')
                    ->options(function () {
                        return Requirement::with('office')
                            ->get()
                            ->filter(fn ($req) => $req->office)
                            ->mapWithKeys(fn ($req) => [
                                $req->office->department_code => $req->office->short_name,
                            ])
                            ->unique()
                            ->toArray();
                    })
                    ->multiple()
                    ->searchable()
                    ->query(function ($query, $data) {
                        if (! empty($data['values'])) {
                            $query->whereHas('requirement', function ($q) use ($data) {
                                $q->whereIn('requiring_agency', $data['values']);
                            });
                        }
                    }),
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
