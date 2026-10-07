<?php

namespace App\Support;

use App\Helper;
use App\Models\Setting;

/**
 * Header and footer content edited on the "Контент" admin page (stored in settings).
 *
 * Every text falls back to its default: the Russian string below, translated with lang/tj.json.
 */
class SiteContent
{
    /**
     * Pages in the header menu: key => [default title, routes highlighting the item].
     *
     * @var array<string, array{0: string, 1: list<string>}>
     */
    public const PAGES = [
        'about' => ['О нас', ['about']],
        'courses' => ['Курсы', ['courses', 'courses.show']],
        'employees' => ['Сотрудники', ['employees', 'employees.show']],
        'camp' => ['Лагерь', ['camp']],
        'services' => ['Услуги', ['services']],
        'galleries' => ['Галерея', ['galleries', 'galleries.show']],
        'faq' => ['FAQs', ['faq']],
    ];

    /**
     * Editable texts: setting key => default (Russian) text.
     *
     * @var array<string, string>
     */
    public const TEXTS = [
        'header.button' => 'Связаться с нами',
        'form.title' => 'Свяжитесь с нами',
        'form.name' => 'ФИО',
        'form.email' => 'Email',
        'form.message' => 'Сообщение',
        'form.button' => 'Отправить',
        'form.success' => 'Спасибо! Ваша заявка отправлена, мы скоро свяжемся с вами.',
        'footer.contacts_title' => 'Kонтакты',
        'footer.hours_title' => 'Мы работаем',
        'footer.courses_title' => 'Курсы',
        'footer.services_title' => 'Дополнительные услуги',
        'footer.copyright' => 'Все права защищены.',
    ];

    /** @var list<string> */
    public const SERVICES = ['Детский психолог', 'Логопед', 'Тренинг-центр', 'КафеСити', 'Коворкинг в будущем'];

    /** Default logo files in public/images. */
    public const LOGOS = [
        'desktop' => 'images/logo.desktop.svg',
        'tablet' => 'images/logo.tablet.svg',
        'mobile' => 'images/logo.mobile.svg',
    ];

    /**
     * Text for the current language; an empty field shows the default text.
     */
    public static function text(string $key): string
    {
        $text = static::localized(Setting::get($key));

        return filled($text) ? $text : __(static::TEXTS[$key]);
    }

    /**
     * Value for the current language only (no fallback to Russian).
     */
    public static function localized(mixed $value): ?string
    {
        return is_array($value) ? ($value[app()->getLocale()] ?? null) : null;
    }

    /**
     * A default text in every language, e.g. ['ru' => 'ФИО', 'tj' => 'Ному насаб'].
     *
     * @return array<string, string>
     */
    public static function translations(string $text): array
    {
        return ['ru' => $text, 'tj' => __($text, [], 'tj')];
    }

    /**
     * Header menu items with the title in the current language.
     *
     * @return list<array{page: string, route: string, active: list<string>, label: string, published: bool}>
     */
    public static function menu(): array
    {
        return collect(static::PAGES)
            ->map(fn (array $page, string $key) => [
                'page' => $key,
                'route' => $key,
                'active' => $page[1],
                'label' => static::localized(Setting::get("menu.{$key}.title")) ?: __($page[0]),
                'published' => static::isPublished($key),
            ])
            ->values()
            ->all();
    }

    public static function isPublished(string $page): bool
    {
        return (bool) (Setting::get("menu.{$page}.published") ?? true);
    }

    /**
     * Label of the language switch shown on the given language version ("Ru", "Tj").
     */
    public static function localeLabel(string $locale): string
    {
        return Setting::get("header.locales.{$locale}") ?: ucfirst($locale);
    }

    public static function logo(string $size): string
    {
        return Helper::media(Setting::get("logo.{$size}"), static::LOGOS[$size]);
    }

    /**
     * Working hours rows: a bold label and an optional value.
     *
     * @return list<array{label: array<string, string|null>, value: array<string, string|null>}>
     */
    public static function hours(): array
    {
        if (is_array($hours = Setting::get('hours'))) {
            return array_values($hours);
        }

        // Settings saved before the "Контент" page had a fixed weekdays / Saturday / Sunday layout.
        return [
            ['label' => static::translations('По будням:'), 'value' => Setting::get('hours_weekdays', static::translations('с 8:00 до 20:00'))],
            ['label' => static::translations('По субботам:'), 'value' => Setting::get('hours_saturday', static::translations('с 09:00 до 18:00'))],
            ['label' => Setting::get('hours_sunday', static::translations('Вск - выходной')), 'value' => []],
        ];
    }

    /**
     * A link entered in the admin: site paths ("/services") get the current language prefix.
     */
    public static function link(?string $url): ?string
    {
        if (blank($url) || ! str_starts_with($url, '/') || str_starts_with($url, '//')) {
            return $url ?: null;
        }

        $locale = app()->getLocale();

        return $locale === config('app.fallback_locale') || str_starts_with($url, "/{$locale}/") || $url === "/{$locale}"
            ? $url
            : rtrim("/{$locale}{$url}", '/');
    }

    /**
     * Items of the "Дополнительные услуги" footer column: text in every language and an optional link.
     *
     * @return list<array{text: array<string, string|null>, url: string|null}>
     */
    public static function services(): array
    {
        $services = Setting::get('footer.services');

        return is_array($services)
            ? array_values(array_map(fn (array $item) => ['text' => $item['text'] ?? [], 'url' => $item['url'] ?? null], $services))
            : array_map(fn (string $text) => ['text' => static::translations($text), 'url' => null], static::SERVICES);
    }
}
