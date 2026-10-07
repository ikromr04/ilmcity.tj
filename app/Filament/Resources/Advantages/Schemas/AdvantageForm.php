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
                        Fields::translations(fn (string $locale, bool $default) => [
                            TextInput::make("title.{$locale}")
                                ->label('Заголовок')
                                ->required($default)
                                ->maxLength(255),
                            Textarea::make("text.{$locale}")
                                ->label('Текст')
                                ->required($default)
                                ->rows(6),
                        ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
