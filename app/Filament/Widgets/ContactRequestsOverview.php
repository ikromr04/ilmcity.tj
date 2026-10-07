<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactRequests\ContactRequestResource;
use App\Models\ContactRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactRequestsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $perDay = ContactRequest::query()
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->get(['created_at'])
            ->countBy(fn (ContactRequest $request) => $request->created_at->toDateString());

        $chart = collect(range(13, 0))
            ->map(fn (int $daysAgo) => (int) ($perDay[now()->subDays($daysAgo)->toDateString()] ?? 0))
            ->all();

        return [
            Stat::make('Новые заявки', ContactRequest::query()->where('is_processed', false)->count())
                ->description('Ждут обработки')
                ->color('danger')
                ->url(ContactRequestResource::getUrl('index')),
            Stat::make('Заявок сегодня', ContactRequest::query()->whereDate('created_at', today())->count()),
            Stat::make('За 14 дней', array_sum($chart))
                ->chart($chart)
                ->color('primary'),
        ];
    }
}
