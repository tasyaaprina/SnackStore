<?php

namespace App\Filament\Clusters\Products\Resources\ProductResource\Widgets;

use App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStats extends BaseWidget
{
    use InteractsWithPageTable;

    public function getTablePage(): string
    {
        return ListProducts::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', $this->getPageTableQuery()->count()),
            Stat::make('Total Stock', $this->getPageTableQuery()->sum('stock')),
            Stat::make('Average Price', number_format($this->getPageTableQuery()->avg('price'), 2)),
        ];
    }
}
