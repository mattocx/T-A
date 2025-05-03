<?php

namespace App\Filament\Widgets;

use App\Models\Package;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PackagePopularityChart extends ApexChartWidget
{
    protected static ?string $heading = 'Paket Terpopuler';

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $packages = Package::withCount('customers')->get();

        $labels = $packages->pluck('name')->toArray();
        $data = $packages->pluck('customers_count')->toArray();

        return [
            'series' => $data,
            'chart' => [
                'type' => 'pie',
                'height' => 350,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
