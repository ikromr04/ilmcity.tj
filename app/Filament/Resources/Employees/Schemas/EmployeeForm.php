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
                    Fields::translations(fn (string $locale, bool $default) => [
                        Section::make('Основное')
                            ->schema([
                                TextInput::make("name.{$locale}")
                                    ->label('ФИО')
                                    ->required($default)
                                    ->maxLength(255),
                                TextInput::make("position.{$locale}")
                                    ->label('Должность / предмет')
                                    ->placeholder('Английский язык'),
                            ])
                            ->columns(2),

                        Section::make('Биография')
                            ->schema([
                                RichEditor::make("bio.{$locale}")
                                    ->hiddenLabel()
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'link'],
                                        ['bulletList', 'orderedList'],
                                        ['undo', 'redo'],
                                    ]),
                            ]),

                        Section::make('Видео')
                            ->description('Блок с видео внизу страницы сотрудника. Показывается, если указана ссылка.')
                            ->schema([
                                TextInput::make("video_title.{$locale}")
                                    ->label('Заголовок блока')
                                    ->placeholder('Тураева М. Уроки в начальной школе.')
                                    ->maxLength(255),
                            ])
                            ->collapsible(),
                    ], 'Тексты'),

                    Section::make('Видео')
                        ->schema([
                            TextInput::make('video_url')
                                ->label('Ссылка на видео')
                                ->url()
                                ->placeholder('https://www.youtube.com/watch?v=...')
                                ->maxLength(255),
                            Fields::image('video_cover', 'employees/video', 'Обложка')
                                ->helperText('Рекомендуемый размер: 1290×464'),
                        ])
                        ->collapsible(),
                ])->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                    Section::make('Раздел')
                        ->schema([
                            Select::make('role')
                                ->hiddenLabel()
                                ->options(Role::class)
                                ->default(Role::Teacher->value)
                                ->selectablePlaceholder(false)
                                ->required(),
                        ]),
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
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->tr('title', 'ru'))
                                ->multiple()
                                ->preload(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
