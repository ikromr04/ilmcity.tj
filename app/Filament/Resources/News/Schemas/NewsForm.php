<?php

namespace App\Filament\Resources\News\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->schema([
                        Fields::translations(fn (string $locale, bool $default) => [
                            TextInput::make("title.{$locale}")
                                ->label('Заголовок')
                                ->required($default)
                                ->maxLength(255),
                            Textarea::make("excerpt.{$locale}")
                                ->label('Текст')
                                ->rows(4),
                        ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                    Section::make('Изображение')
                        ->schema([
                            Fields::image('image', 'news')->hiddenLabel(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
