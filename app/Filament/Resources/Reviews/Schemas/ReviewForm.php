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
                Section::make()
                    ->schema([
                        Fields::translations(fn (string $locale, bool $default) => [
                            TextInput::make("title.{$locale}")
                                ->label('Заголовок')
                                ->required($default)
                                ->maxLength(255),
                            Textarea::make("text.{$locale}")
                                ->label('Текст отзыва')
                                ->required($default)
                                ->rows(6),
                            TextInput::make("author_name.{$locale}")
                                ->label('Автор')
                                ->required($default)
                                ->maxLength(255),
                            TextInput::make("author_caption.{$locale}")
                                ->label('Подпись автора')
                                ->placeholder('Мама Арнольда'),
                        ]),
                    ])
                    ->columnSpan(['lg' => 2]),

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
