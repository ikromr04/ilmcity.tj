<?php

namespace App\Filament\Resources\Partners\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Название')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('url')
                            ->label('Ссылка на сайт')
                            ->url(),
                        Fields::image('logo', 'partners', 'Логотип')
                            ->acceptedFileTypes(['image/svg+xml', 'image/png', 'image/jpeg', 'image/webp'])
                            ->required(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
