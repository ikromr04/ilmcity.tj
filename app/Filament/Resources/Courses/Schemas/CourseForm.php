<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Карточка курса')
                        ->description('Отображается в списках курсов на главной и на странице «Курсы».')
                        ->schema([
                            TextInput::make('title')
                                ->label('Название')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('description')
                                ->label('Краткое описание')
                                ->rows(3),
                        ]),

                    Section::make('Баннер')
                        ->schema([
                            Fields::image('banner', 'courses', 'Изображение баннера')
                                ->helperText('Рекомендуемый размер: 1290×572')
                                ->columnSpanFull(),
                            TextInput::make('banner_title')
                                ->label('Заголовок баннера')
                                ->placeholder('Подготовка к школе для детей с 4 лет')
                                ->columnSpanFull(),
                            Textarea::make('banner_text')
                                ->label('Текст баннера')
                                ->rows(3)
                                ->columnSpanFull(),
                            TextInput::make('price')
                                ->label('Цена')
                                ->placeholder('150 сомони в месяц'),
                            TextInput::make('duration')
                                ->label('Длительность')
                                ->placeholder('6 месяцев'),
                        ])
                        ->columns(2)
                        ->collapsible(),

                    Section::make('Подробное описание')
                        ->schema([
                            TextInput::make('content_title')
                                ->label('Заголовок раздела')
                                ->placeholder('Подарите ребенку яркое будущее с нашими курсами!'),
                            Repeater::make('blocks')
                                ->label('Блоки')
                                ->schema([
                                    Fields::image('image', 'courses/blocks'),
                                    TextInput::make('title')
                                        ->label('Заголовок')
                                        ->required(),
                                    Textarea::make('items')
                                        ->label('Пункты списка')
                                        ->helperText('Каждый пункт — с новой строки')
                                        ->rows(5),
                                ])
                                ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                ->addActionLabel('Добавить блок')
                                ->collapsible()
                                ->grid(2)
                                ->defaultItems(0),
                        ])
                        ->collapsible(),
                ])->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                    Section::make('Преподаватели')
                        ->schema([
                            Select::make('employees')
                                ->hiddenLabel()
                                ->relationship('employees', 'name')
                                ->multiple()
                                ->preload()
                                ->searchable(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
