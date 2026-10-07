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
                    Section::make('Изображение')
                        ->schema([
                            Fields::image('image', 'services')->hiddenLabel(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
