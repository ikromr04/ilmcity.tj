<?php

namespace App\Filament\Resources\Faqs\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->schema([
                        Fields::translations(fn (string $locale, bool $default) => [
                            TextInput::make("question.{$locale}")
                                ->label('Вопрос')
                                ->required($default)
                                ->maxLength(255),
                            Textarea::make("answer.{$locale}")
                                ->label('Ответ')
                                ->required($default)
                                ->rows(5),
                        ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
