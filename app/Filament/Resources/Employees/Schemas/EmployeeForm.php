<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Enums\Role;
use App\Filament\Support\Fields;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Основное')
                        ->schema([
                            TextInput::make('name')
                                ->label('ФИО')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('position')
                                ->label('Должность / предмет')
                                ->placeholder('Английский язык'),
                            Select::make('role')
                                ->label('Раздел')
                                ->options(Role::class)
                                ->default(Role::Teacher->value)
                                ->selectablePlaceholder(false)
                                ->required(),
                        ])
                        ->columns(2),

                    Section::make('Биография')
                        ->schema([
                            RichEditor::make('bio')
                                ->hiddenLabel()
                                ->toolbarButtons([
                                    ['bold', 'italic', 'underline', 'link'],
                                    ['bulletList', 'orderedList'],
                                    ['undo', 'redo'],
                                ]),
                        ]),
                ])->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                    Section::make('Фото')
                        ->schema([
                            Fields::image('photo', 'employees', 'Фото')
                                ->hiddenLabel()
                                ->imageAspectRatio('3:4'),
                        ]),
                    Section::make('Курсы')
                        ->schema([
                            Select::make('courses')
                                ->hiddenLabel()
                                ->relationship('courses', 'title')
                                ->multiple()
                                ->preload()
                                ->searchable(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
