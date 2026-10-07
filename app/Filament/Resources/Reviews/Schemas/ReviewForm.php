<?php

namespace App\Filament\Resources\Reviews\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Отзыв')
                        ->schema([
                            TextInput::make('title')
                                ->label('Заголовок')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('text')
                                ->label('Текст')
                                ->required()
                                ->rows(6),
                        ]),
                    Section::make('Автор')
                        ->schema([
                            TextInput::make('author_name')
                                ->label('Имя')
                                ->required(),
                            TextInput::make('author_caption')
                                ->label('Подпись')
                                ->placeholder('Мама Арнольда'),
                        ])
                        ->columns(2),
                ])->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                    Section::make('Фото автора')
                        ->schema([
                            Fields::image('photo', 'reviews')
                                ->hiddenLabel()
                                ->avatar(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
