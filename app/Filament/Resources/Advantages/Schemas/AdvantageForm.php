<?php

namespace App\Filament\Resources\Advantages\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdvantageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->description('Слайдер «Инвестиции в будущее» на главной странице.')
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
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
