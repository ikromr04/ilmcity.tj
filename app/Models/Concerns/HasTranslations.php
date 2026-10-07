<?php

namespace App\Models\Concerns;

use App\Helper;

/**
 * Attributes listed in $translatable are JSON columns holding every site language,
 * e.g. {"ru": "Математика", "tj": "Математика"}.
 *
 * Reading such an attribute returns the text for the current locale (with fallback to
 * the default one); the admin forms edit the raw array via "title.ru", "title.tj".
 */
trait HasTranslations
{
    public function initializeHasTranslations(): void
    {
        $this->mergeCasts(array_fill_keys($this->translatable, 'array'));
    }

    /**
     * @return list<string>
     */
    public function translatableAttributes(): array
    {
        return $this->translatable;
    }

    public function isTranslatable(string $key): bool
    {
        return in_array($key, $this->translatable, true);
    }

    public function getAttributeValue($key): mixed
    {
        $value = parent::getAttributeValue($key);

        return $this->isTranslatable($key) ? Helper::tr($value) : $value;
    }

    /**
     * A plain string is stored as the default-locale text.
     */
    public function setAttribute($key, $value): mixed
    {
        if ($this->isTranslatable($key) && is_string($value)) {
            $value = [config('app.fallback_locale') => $value];
        }

        return parent::setAttribute($key, $value);
    }

    public function tr(string $attribute, ?string $locale = null): ?string
    {
        return Helper::tr(parent::getAttributeValue($attribute), $locale);
    }

    /**
     * @return array<string, string|null>
     */
    public function getTranslations(string $attribute): array
    {
        return (array) parent::getAttributeValue($attribute);
    }
}
