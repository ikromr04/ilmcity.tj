<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('text')
                            ->label('Текст')
                            ->required()
                            ->rows(6),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                    Section::make('Изображение')
                        ->schema([
                            Fields::image('image', 'services')->hiddenLabel(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
