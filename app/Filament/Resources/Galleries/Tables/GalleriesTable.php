<?php

namespace App\Filament\Resources\Galleries\Tables;

use App\Filament\Support\Fields;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                    ->label('Фото')
                    ->disk('public')
                    ->stacked()
                    ->limit(4)
                    ->limitedRemainingText(),
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('date')
                    ->label('Дата')
                    ->date('d.m.Y')
                    ->sortable(),
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
