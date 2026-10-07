<?php

namespace App\Filament\Pages;

use App\Enums\Locale;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ManageSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected static ?string $navigationLabel = 'Настройки сайта';

    protected static ?string $title = 'Настройки сайта';

    protected static ?string $slug = 'settings';

    /** Keys stored in the settings table. */
    public const KEYS = ['phone', 'email', 'telegram', 'instagram', 'map', 'video', 'address', 'hours_weekdays', 'hours_saturday', 'hours_sunday', 'license', 'stats'];

    /** @var array<string, mixed> | null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(collect(self::KEYS)->mapWithKeys(fn ($key) => [$key => Setting::get($key)])->all());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make()
                    ->tabs([
                        Tab::make('Контакты')
                            ->icon(Heroicon::OutlinedPhone)
                            ->schema([
                                TextInput::make('phone')->label('Телефон')->tel(),
                                TextInput::make('email')->label('Email')->email(),
                                TextInput::make('telegram')->label('Telegram')->url(),
                                TextInput::make('instagram')->label('Instagram')->url(),
                                ...$this->localized('address', 'Адрес'),
                                Textarea::make('map')
                                    ->label('Ссылка на карту (Google Maps embed src)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('График работы')
                            ->icon(Heroicon::OutlinedClock)
                            ->schema([
                                ...$this->localized('hours_weekdays', 'По будням'),
                                ...$this->localized('hours_saturday', 'По субботам'),
                                ...$this->localized('hours_sunday', 'Воскресенье'),
                            ])
                            ->columns(2),

                        Tab::make('Главная страница')
                            ->icon(Heroicon::OutlinedHome)
                            ->schema([
                                FileUpload::make('video')
                                    ->label('Видео')
                                    ->disk('public')
                                    ->directory('video')
                                    ->acceptedFileTypes(['video/mp4', 'video/webm'])
                                    ->maxSize(102400)
                                    ->helperText('Если не загружено — используется стандартное видео.'),
                                Repeater::make('stats')
                                    ->label('Цифры')
                                    ->schema([
                                        TextInput::make('value')->label('Значение')->placeholder('130+')->required(),
                                        TextInput::make('label_ru')->label('Подпись (RU)')->required(),
                                        TextInput::make('label_tj')->label('Подпись (TJ)'),
                                    ])
                                    ->columns(3)
                                    ->maxItems(3)
                                    ->reorderable(),
                            ]),

                        Tab::make('Подвал')
                            ->icon(Heroicon::OutlinedDocumentText)
                            ->schema([
                                ...$this->localized('license', 'Текст лицензии'),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Сохранить')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        Setting::put($this->form->getState());

        Notification::make()
            ->success()
            ->title('Настройки сохранены')
            ->send();
    }

    /**
     * One text input per site locale, stored as "{key}.{locale}".
     *
     * @return array<TextInput>
     */
    protected function localized(string $key, string $label): array
    {
        return array_map(
            fn (Locale $locale) => TextInput::make("{$key}.{$locale->value}")
                ->label("{$label} (".strtoupper($locale->value).')'),
            Locale::cases(),
        );
    }
}
