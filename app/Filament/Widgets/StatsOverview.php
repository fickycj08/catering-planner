<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Inventory;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected static bool $isLazy = true;

    protected function getCards(): array
    {
        $orderStats = $this->getOrderStatistics();
        $revenue = $this->calculateRevenue();

        return [
            // Order Metrics Section
            // Ubah dari formatCurrency() ke currency()
            Stat::make('Total Revenue', Number::currency($revenue['current'], 'IDR', 'id'))
                ->description($this->getRevenueTrend($revenue))
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->chart($this->getRevenueChartData())
                ->descriptionIcon($this->getRevenueDescriptionIcon($revenue)),

            Stat::make('Active Orders', $orderStats['active'])
                ->description($this->getOrderTrend('processing'))
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->chart($orderStats['order_trends']),

            Stat::make('Completed Orders', $orderStats['completed'])
                ->description($this->getCompletionRate($orderStats))
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->chart($orderStats['completion_trends']),

            // System Metrics Section
            Stat::make('Total Customers', Customer::count())
                ->description($this->getNewCustomersThisMonth())
                ->icon('heroicon-o-user-plus')
                ->color('purple')
                ->chart($this->getCustomerGrowthData()),

            Stat::make('Available Menu', Menu::where('is_available', true)->count())
                ->description($this->getMenuStatus())
                ->icon('heroicon-o-book-open')
                ->color('warning')
                ->extraAttributes(['class' => 'animate-pulse']),


        ];
    }

    private function getOrderStatistics(): array
    {
        return [
            'active' => Order::whereIn('status', ['pending', 'processing'])->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'order_trends' => $this->generateOrderTrendData('processing', now()->subDays(30)),
            'completion_trends' => $this->generateOrderTrendData('completed', now()->subWeek())
        ];
    }


    private function calculateRevenue(): array
    {
        $current = Order::where('status', 'completed')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_price');

        $previous = Order::where('status', 'completed')
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->sum('total_price');

        return [
            'current' => $current,
            'previous' => $previous,
            'change' => $previous != 0 ? (($current - $previous) / $previous) * 100 : ($current > 0 ? 100 : 0)
        ];
    }

    private function generateOrderTrendData(string $status, Carbon $startDate): array
    {
        $query = Order::where('status', $status)
            ->where('created_at', '>=', $startDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->orderBy('date');

        $data = $query->pluck('count', 'date')->toArray();

        return $this->fillMissingDates($data, $startDate, now());
    }

    private function fillMissingDates(array $data, Carbon $start, Carbon $end): array
    {
        $filled = [];
        $current = $start->copy();

        while ($current <= $end) {
            $date = $current->format('Y-m-d');
            $filled[] = $data[$date] ?? 0;
            $current->addDay();
        }

        return $filled;
    }

    private function getRevenueTrend(array $revenue): string
    {
        $trend = $revenue['change'] >= 0 ? 'increase' : 'decrease';
        $color = $trend === 'increase' ? 'text-green-500' : 'text-red-500';

        return sprintf(
            '%s%.2f%% dari bulan lalu',
            $trend === 'increase' ? '+' : '-',
            abs($revenue['change'])
        );
    }

    private function getRevenueDescriptionIcon(array $revenue): string
    {
        return $revenue['change'] >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down';
    }

    private function getCustomerGrowthData(): array
    {
        $rawData = Customer::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->pluck('count', 'date')
            ->toArray();

        return $this->fillMissingDates($rawData, now()->subDays(30), now());
    }

    private function getNewCustomersThisMonth(): string
    {
        $count = Customer::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return $count > 0 ? "{$count} baru bulan ini" : 'Tidak ada pelanggan baru';
    }

    private function getMenuStatus(): string
    {
        $total = Menu::count();
        $available = Menu::where('is_available', true)->count();

        return "{$available}/{$total} tersedia";
    }

    private function getOrderTrend(string $status): string
    {
        // Hitung order bulan ini
        $currentPeriodCount = Order::where('status', $status)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        // Hitung order bulan lalu
        $previousPeriodCount = Order::where('status', $status)
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->count();

        // Hitung persentase perubahan
        $percentageChange = 0;
        if ($previousPeriodCount > 0) {
            $percentageChange = (($currentPeriodCount - $previousPeriodCount) / $previousPeriodCount) * 100;
        } elseif ($currentPeriodCount > 0) {
            $percentageChange = 100;
        }

        // Tentukan trend
        $trendIcon = '';
        $trendText = 'Tidak ada perubahan';  // Default text when no change
        $colorClass = '';  // Initialize colorClass as empty

        if ($percentageChange > 0) {
            $trendIcon = '↑';
            $colorClass = 'text-green-500';  // Green color for increase
            $trendText = sprintf('%.1f%% naik sejak bulan lalu', abs($percentageChange));
        } elseif ($percentageChange < 0) {
            $trendIcon = '↓';
            $colorClass = 'text-red-500';  // Red color for decrease
            $trendText = sprintf('%.1f%% turun sejak bulan lalu', abs($percentageChange));
        }

        // Only include color class when there is a change
        if ($colorClass) {
            return sprintf(
                '<span class="%s">%s</span>',
                $colorClass,
                $trendText
            );
        } else {
            return $trendText;  // Just return the text without any span when no change
        }


    }

    private function getCompletionRate(array $orderStats): string
    {
        $totalOrders = $orderStats['active'] + $orderStats['completed'];
        $rate = $totalOrders > 0 ? ($orderStats['completed'] / $totalOrders) * 100 : 0;

        return sprintf(
            '%.1f%% completion rate',
            $rate
        );
    }


    private function getRevenueChartData(): array
    {
        // Ambil data revenue 30 hari terakhir
        $startDate = now()->subDays(30)->startOfDay();
        $endDate = now()->endOfDay();

        $revenueData = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        // Generate array untuk hari yang tidak ada transaksi
        $chartData = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('Y-m-d');
            $chartData[] = $revenueData[$formattedDate] ?? 0;
            $currentDate->addDay();
        }

        return $chartData;
    }

}
