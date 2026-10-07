<?php

namespace App\Filament\Resources\ContactRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('ФИО')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('course.title')
                    ->label('Курс')
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('message')
                    ->label('Сообщение')
                    ->limit(60)
                    ->toggleable(),
                ToggleColumn::make('is_processed')
                    ->label('Обработана'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_processed')
                    ->label('Обработана'),
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
