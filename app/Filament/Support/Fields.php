<?php

namespace App\Filament\Support;

use App\Enums\Locale;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;

/**
 * Reusable form fields, columns and filters shared by the content resources.
 */
class Fields
{
    public static function locale(): Select
    {
        return Select::make('locale')
            ->label('Язык')
            ->options(Locale::class)
            ->default(Locale::default()->value)
            ->selectablePlaceholder(false)
            ->required();
    }

    public static function published(): Toggle
    {
        return Toggle::make('is_published')
            ->label('Опубликовано')
            ->default(true);
    }

    /**
     * Sidebar section with language + publish toggle.
     */
    public static function meta(bool $localized = true): Section
    {
        return Section::make('Публикация')
            ->schema(array_filter([
                $localized ? static::locale() : null,
                static::published(),
            ]));
    }

    public static function image(string $name, string $directory, string $label = 'Изображение'): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->disk('public')
            ->directory($directory)
            ->imageEditor()
            ->maxSize(10240);
    }

    public static function localeColumn(): TextColumn
    {
        return TextColumn::make('locale')
            ->label('Язык')
            ->badge()
            ->formatStateUsing(fn (string $state) => strtoupper($state))
            ->color(fn (string $state) => $state === 'tj' ? 'success' : 'info');
    }

    public static function publishedColumn(): ToggleColumn
    {
        return ToggleColumn::make('is_published')->label('Опубл.');
    }

    public static function imageColumn(string $name, string $label = 'Фото'): ImageColumn
    {
        return ImageColumn::make($name)->label($label)->disk('public');
    }

    public static function localeFilter(): SelectFilter
    {
        return SelectFilter::make('locale')
            ->label('Язык')
            ->options(Locale::class);
    }
}
