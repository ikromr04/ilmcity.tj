<?php

namespace App\Filament\Resources\Galleries\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Альбом')
                        ->schema([
                            TextInput::make('title')
                                ->label('Название')
                                ->required()
                                ->maxLength(255),
                            DatePicker::make('date')
                                ->label('Дата')
                                ->native(false)
                                ->displayFormat('d.m.Y')
                                ->default(now()),
                        ])
                        ->columns(2),

                    Section::make('Фотографии')
                        ->description('Первое фото используется как обложка. Порядок меняется перетаскиванием.')
                        ->schema([
                            FileUpload::make('images')
                                ->hiddenLabel()
                                ->image()
                                ->multiple()
                                ->reorderable()
                                ->appendFiles()
                                ->panelLayout('grid')
                                ->disk('public')
                                ->directory('galleries')
                                ->maxSize(10240)
                                ->maxParallelUploads(4),
                        ]),
                ])->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
