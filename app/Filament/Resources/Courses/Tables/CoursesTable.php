<?php

namespace App\Filament\Resources\Courses\Tables;

use App\Filament\Support\Fields;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Fields::imageColumn('banner', 'Баннер'),
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('price')
                    ->label('Цена')
                    ->toggleable(),
                TextColumn::make('employees_count')
                    ->label('Преподаватели')
                    ->counts('employees')
                    ->badge(),
                Fields::localeColumn(),
                Fields::publishedColumn(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->filters([
                Fields::localeFilter(),
            ])
            ->recordActions([
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
