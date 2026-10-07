<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * Home page settings; header and footer are edited on the "Контент" page.
 *
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
    public const KEYS = ['video', 'stats'];

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
                Section::make('Главная страница')
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
}
