<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared behaviour for content managed in the admin panel:
 * publish toggle and manual sorting.
 */
trait Publishable
{
    public function initializePublishable(): void
    {
        $this->mergeCasts(['is_published' => 'boolean']);
    }

    #[Scope]
    protected function visible(Builder $query): void
    {
        $query->where($this->qualifyColumn('is_published'), true)
            ->orderBy($this->qualifyColumn('sort'))
            ->orderBy($this->qualifyColumn('id'));
    }
}
