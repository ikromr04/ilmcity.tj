<?php

namespace App\Filament\Resources\Partners\Tables;

use App\Filament\Support\Fields;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Fields::imageColumn('logo', 'Логотип'),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('url')
                    ->label('Сайт')
                    ->url(fn ($record) => $record->url, shouldOpenInNewTab: true)
                    ->toggleable(),
                Fields::publishedColumn(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
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
