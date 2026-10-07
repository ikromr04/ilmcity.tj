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
                            Fields::translations(fn (string $locale, bool $default) => [
                                TextInput::make("title.{$locale}")
                                    ->label('Название')
                                    ->required($default)
                                    ->maxLength(255),
                            ]),
                            DatePicker::make('date')
                                ->label('Дата')
                                ->native(false)
                                ->displayFormat('d.m.Y')
                                ->default(now()),
                        ])
                        ->columns(2),

                    Section::make('Фото и видео')
                        ->description('Первый файл используется как обложка. Порядок меняется перетаскиванием. Видео — MP4 или WebM.')
                        ->schema([
                            FileUpload::make('images')
                                ->hiddenLabel()
                                ->acceptedFileTypes(['image/*', 'video/mp4', 'video/webm'])
                                ->multiple()
                                ->reorderable()
                                ->appendFiles()
                                ->panelLayout('grid')
                                ->disk('public')
                                ->directory('galleries')
                                ->maxSize(102400)
                                ->maxParallelUploads(4),
                        ]),
                ])->columnSpan(['lg' => 2]),

                Group::make([
                    Fields::meta(),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
