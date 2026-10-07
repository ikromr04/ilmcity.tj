<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared behaviour for content managed in the admin panel:
 * publish toggle, manual sorting and (optionally) per-locale records.
 */
trait Publishable
{
    public function initializePublishable(): void
    {
        $this->mergeCasts(['is_published' => 'boolean']);
    }

    public function isLocalized(): bool
    {
        return true;
    }

    #[Scope]
    protected function visible(Builder $query): void
    {
        $query->where($this->qualifyColumn('is_published'), true)
            ->orderBy($this->qualifyColumn('sort'))
            ->orderBy($this->qualifyColumn('id'));

        if ($this->isLocalized()) {
            $query->where($this->qualifyColumn('locale'), app()->getLocale());
        }
    }
}
