<?php

namespace App\Filament\Resources\ContactRequests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('ФИО')
                            ->required(),
                        TextInput::make('phone')
                            ->label('Телефон')
                            ->tel(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Select::make('course_id')
                            ->label('Курс')
                            ->relationship('course', 'title')
                            ->searchable()
                            ->preload(),
                        Textarea::make('message')
                            ->label('Сообщение')
                            ->rows(5)
                            ->columnSpanFull(),
                        Toggle::make('is_processed')
                            ->label('Обработана'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
