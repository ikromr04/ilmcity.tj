<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Filament\Support\Fields;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Fields::imageColumn('photo')->circular(),
                TextColumn::make('author_name')
                    ->label('Автор')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->author_caption),
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->limit(50),
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
