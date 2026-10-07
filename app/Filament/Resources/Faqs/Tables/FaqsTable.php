<?php

namespace App\Filament\Resources\Faqs\Tables;

use App\Filament\Support\Fields;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->label('Вопрос')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn ($record) => str($record->answer)->limit(90)),
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
