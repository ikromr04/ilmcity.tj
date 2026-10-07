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
                    Fields::translations(fn (string $locale, bool $default) => [
                        Section::make('Карточка курса')
                            ->description('Отображается в списках курсов на главной и на странице «Курсы».')
                            ->schema([
                                TextInput::make("title.{$locale}")
                                    ->label('Название')
                                    ->required($default)
                                    ->maxLength(255),
                                Textarea::make("description.{$locale}")
                                    ->label('Краткое описание')
                                    ->rows(3),
                            ]),

                        Section::make('Баннер')
                            ->schema([
                                TextInput::make("banner_title.{$locale}")
                                    ->label('Заголовок баннера')
                                    ->placeholder('Подготовка к школе для детей с 4 лет')
                                    ->columnSpanFull(),
                                Textarea::make("banner_text.{$locale}")
                                    ->label('Текст баннера')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make("price.{$locale}")
                                    ->label('Цена')
                                    ->placeholder('150 сомони в месяц'),
                                TextInput::make("duration.{$locale}")
                                    ->label('Длительность')
                                    ->placeholder('6 месяцев'),
                            ])
                            ->columns(2)
                            ->collapsible(),

                        Section::make('Подробное описание')
                            ->schema([
                                TextInput::make("content_title.{$locale}")
                                    ->label('Заголовок раздела')
                                    ->placeholder('Подарите ребенку яркое будущее с нашими курсами!'),
                            ])
                            ->collapsible(),
                    ], 'Тексты'),

                    Section::make('Блоки страницы курса')
                        ->description('Карточки с картинкой и списком (например «В программе», «Расписание»).')
                        ->schema([
                            Repeater::make('blocks')
                                ->hiddenLabel()
                                ->schema([
                                    Fields::image('image', 'courses/blocks'),
                                    Fields::translations(fn (string $locale, bool $default) => [
                                        TextInput::make("title.{$locale}")
                                            ->label('Заголовок')
                                            ->required($default),
                                        Textarea::make("items.{$locale}")
                                            ->label('Пункты списка')
                                            ->helperText('Каждый пункт — с новой строки')
                                            ->rows(5),
                                    ]),
                                ])
                                ->itemLabel(fn (array $state): ?string => $state['title']['ru'] ?? null)
                                ->addActionLabel('Добавить блок')
                                ->collapsible()
                                ->grid(2)
                                ->defaultItems(0),
                        ])
                        ->collapsible(),
                ])->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                    Section::make('Баннер')
                        ->schema([
                            Fields::image('banner', 'courses', 'Изображение баннера')
                                ->hiddenLabel()
                                ->helperText('Рекомендуемый размер: 1290×572'),
                        ]),
                    Section::make('Преподаватели')
                        ->schema([
                            Select::make('employees')
                                ->hiddenLabel()
                                ->relationship('employees', 'name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => $record->tr('name', 'ru'))
                                ->multiple()
                                ->preload(),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
