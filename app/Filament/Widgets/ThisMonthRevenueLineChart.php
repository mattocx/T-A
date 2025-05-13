<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ThisMonthRevenueLineChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'thisMonthRevenue';

    /**
     * Widget Title
     *
     * @var string|null
     */

    protected function getHeading(): null|string|Htmlable|View
    {
        $thisMonth = Carbon::now()->format('F');
        return __('Pendapatan bulan ') . $thisMonth;
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $thisMonth = Carbon::now()->format('F');
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $period = CarbonPeriod::create($startOfMonth, $endOfMonth);

        $labels = [];
        $data = [];
        foreach($period as $date) {
            $customersThisDate = Customer::with('package')
                ->whereDate('created_at', $date)
                ->get();

            $incomeOnDate = 0;
            $customersThisDate->map(function($customer) use (&$incomeOnDate) {
                $incomeOnDate += $customer->package->price ?? 0;
            });

            $labels[] = $date->format('d');
            $data[] = $incomeOnDate;
        }

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => __('Pendapatan bulan ') . $thisMonth,
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
