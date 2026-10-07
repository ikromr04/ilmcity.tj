<?php

namespace App\Filament\Pages;

use App\Enums\Locale;
use App\Models\Setting;
use App\Support\SiteContent;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * Header and footer of the site: logo, menu, contact form, contacts, map, etc.
 *
 * @property-read Schema $form
 */
class Content extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Контент';

    protected static ?string $title = 'Контент';

    protected static ?string $slug = 'content';

    /** @var array<string, mixed> | null */
    public ?array $data = [];

    public function mount(): void
    {
        $data = [
            'logo' => Setting::get('logo', []),
            'hours' => SiteContent::hours(),
            'footer' => [
                'services' => SiteContent::services(),
            ],
        ];

        foreach (SiteContent::PAGES as $page => [$title]) {
            $data['menu'][$page] = [
                'title' => Setting::get("menu.{$page}.title") ?? SiteContent::translations($title),
                'published' => SiteContent::isPublished($page),
            ];
        }

        foreach (SiteContent::TEXTS as $key => $default) {
            data_set($data, $key, Setting::get($key) ?? SiteContent::translations($default));
        }

        foreach (Locale::cases() as $locale) {
            $data['header']['locales'][$locale->value] = SiteContent::localeLabel($locale->value);
        }

        foreach (['phone', 'email', 'telegram', 'instagram', 'address', 'map', 'license', 'license_file'] as $key) {
            $data[$key] = Setting::get($key);
        }

        $this->form->fill($data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make()
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('Шапка сайта')
                            ->icon(Heroicon::OutlinedBars3)
                            ->schema(static::header()),
                        Tab::make('Подвал сайта')
                            ->icon(Heroicon::OutlinedRectangleStack)
                            ->schema(static::footer()),
                    ]),
            ]);
    }

    /**
     * @return array<int, mixed>
     */
    protected static function header(): array
    {
        return [
            Section::make('Логотип')
                ->description('Если не загружен — используется стандартный логотип. Он же показывается в подвале.')
                ->schema([
                    static::logo('desktop', 'Компьютер'),
                    static::logo('tablet', 'Планшет'),
                    static::logo('mobile', 'Телефон'),
                ])
                ->columns(3),

            Section::make('Меню')
                ->description('Название страницы в меню. Если выключить «Опубликована», страница пропадёт из меню и перестанет открываться.')
                ->schema(collect(SiteContent::PAGES)
                    ->map(fn (array $page, string $key) => Fieldset::make()
                        ->schema([
                            ...static::localized("menu.{$key}.title", fn (Locale $locale) => $locale->getLabel(), required: true),
                            Toggle::make("menu.{$key}.published")
                                ->label('Опубликована')
                                ->inline(false)
                                ->live()
                                ->afterStateUpdated(fn (bool $state) => static::publishPage($key, $state)),
                        ])
                        ->columns(3))
                    ->values()
                    ->all()),

            Section::make('Кнопка «Связаться с нами»')
                ->description('Ведёт к форме заявки внизу страницы.')
                ->schema(static::localized('header.button', fn (Locale $locale) => $locale->getLabel(), required: true))
                ->columns(2),

            Section::make('Кнопка языка')
                ->description('Показывает текущий язык сайта; нажатие переключает на другой.')
                ->schema(array_map(
                    fn (Locale $locale) => TextInput::make("header.locales.{$locale->value}")
                        ->label("На версии «{$locale->getLabel()}»")
                        ->placeholder(ucfirst($locale->value))
                        ->required()
                        ->maxLength(10),
                    Locale::cases(),
                ))
                ->columns(2),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function footer(): array
    {
        return [
            Section::make('Форма заявки')
                ->description('Подписи используются и в окне «Регистрация на курс».')
                ->schema([
                    static::pair('form.title', 'Заголовок'),
                    static::pair('form.name', 'Поле «ФИО»'),
                    static::pair('form.email', 'Поле «Email»'),
                    static::pair('form.message', 'Поле «Сообщение»'),
                    static::pair('form.button', 'Кнопка'),
                    static::pair('form.success', 'Сообщение после отправки', textarea: true),
                ])
                ->collapsible(),

            Section::make('Карта')
                ->schema([
                    Textarea::make('map')
                        ->label('Ссылка на карту')
                        ->helperText('Google Maps: «Поделиться» → «Встраивание карт» → скопируйте адрес из src="…".')
                        ->rows(3),
                ])
                ->collapsible(),

            Section::make('Контакты')
                ->schema([
                    static::pair('footer.contacts_title', 'Заголовок колонки'),
                    Grid::make(2)->schema([
                        TextInput::make('phone')->label('Телефон')->tel(),
                        TextInput::make('email')->label('Email')->email(),
                        TextInput::make('telegram')->label('Telegram')->url(),
                        TextInput::make('instagram')->label('Instagram')->url(),
                    ]),
                    static::pair('address', 'Адрес'),
                ])
                ->collapsible(),

            Section::make('График работы')
                ->schema([
                    static::pair('footer.hours_title', 'Заголовок колонки'),
                    Repeater::make('hours')
                        ->label('Строки')
                        ->schema([
                            ...static::localized('label', fn (Locale $locale) => "Название ({$locale->getLabel()})", required: true),
                            ...static::localized('value', fn (Locale $locale) => "Время ({$locale->getLabel()})"),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->addActionLabel('Добавить строку')
                        ->helperText('Например: «По будням:» — «с 8:00 до 20:00». Время можно оставить пустым («Вск - выходной»).'),
                ])
                ->collapsible(),

            Section::make('Курсы')
                ->description('В колонке показываются первые пять опубликованных курсов из раздела «Курсы».')
                ->schema([
                    static::pair('footer.courses_title', 'Заголовок колонки'),
                ])
                ->collapsible(),

            Section::make('Дополнительные услуги')
                ->schema([
                    static::pair('footer.services_title', 'Заголовок колонки'),
                    Repeater::make('footer.services')
                        ->label('Пункты')
                        ->schema([
                            ...static::localized('text', fn (Locale $locale) => $locale->getLabel(), required: true),
                            TextInput::make('url')
                                ->label('Ссылка')
                                ->placeholder('/services или https://…')
                                ->helperText('Необязательно. Адрес страницы сайта (например /services) или полная ссылка на другой сайт.')
                                ->rule('regex:/^(https?:\/\/\S+|\/\S*)$/i')
                                ->validationMessages(['regex' => 'Укажите адрес, начинающийся с / или https://'])
                                ->maxLength(255)
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->addActionLabel('Добавить пункт'),
                ])
                ->collapsible(),

            Section::make('Лицензия и копирайт')
                ->schema([
                    static::pair('license', 'Текст лицензии (под логотипом)', textarea: true),
                    FileUpload::make('license_file')
                        ->label('Файл лицензии')
                        ->helperText('PDF или изображение. Если загружен — текст лицензии на сайте становится ссылкой на этот файл.')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                        ->disk('public')
                        ->directory('license')
                        ->maxSize(20480)
                        ->openable()
                        ->downloadable(),
                    static::pair('footer.copyright', 'Копирайт (после «© '.date('Y').' IlmCity.»)'),
                ])
                ->collapsible(),
        ];
    }

    /**
     * The publish switch is saved right away, without the "Сохранить" button.
     */
    protected static function publishPage(string $page, bool $published): void
    {
        $menu = Setting::get('menu', []);
        data_set($menu, "{$page}.published", $published);

        Setting::put(['menu' => $menu]);

        Notification::make()
            ->success()
            ->title($published ? 'Страница опубликована' : 'Страница скрыта')
            ->body(__(SiteContent::PAGES[$page][0]))
            ->send();
    }

    /**
     * Russian and Tajik inputs of one text side by side.
     */
    protected static function pair(string $path, string $label, bool $textarea = false): Fieldset
    {
        return Fieldset::make($label)
            ->schema(static::localized($path, fn (Locale $locale) => $locale->getLabel(), $textarea))
            ->columns(2);
    }

    /**
     * One input per language for "{$path}.{locale}".
     *
     * @param  callable(Locale): string  $label
     * @return list<TextInput|Textarea>
     */
    protected static function localized(string $path, callable $label, bool $textarea = false, bool $required = false): array
    {
        return array_map(
            fn (Locale $locale) => ($textarea ? Textarea::make("{$path}.{$locale->value}")->rows(2) : TextInput::make("{$path}.{$locale->value}"))
                ->label($label($locale))
                ->required($required && $locale === Locale::default()),
            Locale::cases(),
        );
    }

    protected static function logo(string $size, string $label): FileUpload
    {
        return FileUpload::make("logo.{$size}")
            ->label($label)
            ->image()
            ->acceptedFileTypes(['image/svg+xml', 'image/png', 'image/webp', 'image/jpeg'])
            ->disk('public')
            ->directory('logo')
            ->maxSize(2048);
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
        $state = $this->form->getState();
        $state['hours'] = array_values($state['hours'] ?? []);
        $state['footer']['services'] = array_values($state['footer']['services'] ?? []);

        Setting::put($state);

        Notification::make()
            ->success()
            ->title('Сохранено')
            ->send();
    }
}
