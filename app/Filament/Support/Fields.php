<?php

namespace App\Filament\Support;

use App\Enums\Locale;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;

/**
 * Reusable form fields and columns shared by the content resources.
 */
class Fields
{
    /**
     * One tab per site language for translatable JSON attributes.
     *
     * The closure receives the locale and whether it is the default one and returns
     * the fields of that tab, e.g. TextInput::make("title.{$locale}")->required($default).
     */
    public static function translations(Closure $fields, string $label = 'Переводы'): Tabs
    {
        return Tabs::make($label)
            ->tabs(array_map(
                fn (Locale $locale) => Tab::make($locale->getLabel())
                    ->schema($fields($locale->value, $locale === Locale::default())),
                Locale::cases(),
            ))
            ->columnSpanFull();
    }

    public static function published(): Toggle
    {
        return Toggle::make('is_published')
            ->label('Опубликовано')
            ->default(true);
    }

    /**
     * Sidebar section with the publish toggle.
     */
    public static function meta(): Section
    {
        return Section::make('Публикация')
            ->schema([
                static::published(),
            ]);
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

    public static function publishedColumn(): ToggleColumn
    {
        return ToggleColumn::make('is_published')->label('Опубл.');
    }

    public static function imageColumn(string $name, string $label = 'Фото'): ImageColumn
    {
        return ImageColumn::make($name)->label($label)->disk('public');
    }

    /**
     * Table action opening the record's public page in a new tab.
     */
    public static function viewOnSite(string $route): Action
    {
        return Action::make('view')
            ->label('На сайте')
            ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
            ->color('gray')
            ->url(fn ($record) => route($route, $record))
            ->openUrlInNewTab();
    }
}
