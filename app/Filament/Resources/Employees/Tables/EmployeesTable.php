<?php

namespace App\Filament\Resources\Employees\Tables;

use App\Enums\Role;
use App\Filament\Support\Fields;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Fields::imageColumn('photo')->circular(),
                TextColumn::make('name')
                    ->label('ФИО')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->position),
                TextColumn::make('role')
                    ->label('Раздел')
                    ->badge(),
                TextColumn::make('certificates_count')
                    ->label('Сертификаты')
                    ->counts('certificates')
                    ->badge()
                    ->color('gray'),
                Fields::publishedColumn(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->filters([
                SelectFilter::make('role')
                    ->label('Раздел')
                    ->options(Role::class),
            ])
            ->recordActions([
                Fields::viewOnSite('employees.show'),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
