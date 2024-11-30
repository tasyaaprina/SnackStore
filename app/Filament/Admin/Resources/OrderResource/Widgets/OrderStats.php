<?php

namespace App\Filament\Admin\Resources\OrderResource\Widgets;

use App\Models\Order;
use Flowframe\Trend\Trend;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Admin\Resources\OrderResource\Pages\ListOrders;
use Flowframe\Trend\TrendValue;

class OrderStats extends BaseWidget
{
    use InteractsWithTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListOrders::class;
    }

    protected function getStats(): array
    {
        $orderData = Trend::model(Order::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Orders', $this->getPageTableQuery()->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Stat::make('Open orders', $this->getPageTableQuery()->whereIn('status', ['open', 'processing'])->count()),
            Stat::make('Average Price', number_format($this->getPageTableQuery()->avg('total_price'), 2))
        ];
    }
}
