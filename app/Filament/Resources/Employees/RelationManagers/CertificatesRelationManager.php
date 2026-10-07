<?php

namespace App\Filament\Resources\Employees\RelationManagers;

use App\Filament\Support\Fields;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CertificatesRelationManager extends RelationManager
{
    protected static string $relationship = 'certificates';

    protected static ?string $title = 'Сертификаты';

    protected static ?string $modelLabel = 'сертификат';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fields::image('image', 'certificates')
                    ->columnSpanFull(),
                Fields::translations(fn (string $locale, bool $default) => [
                    TextInput::make("title.{$locale}")
                        ->label('Название')
                        ->required($default),
                    Textarea::make("description.{$locale}")
                        ->label('Описание')
                        ->rows(3),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Fields::imageColumn('image', 'Изображение'),
                TextColumn::make('title')
                    ->label('Название')
                    ->wrap(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
