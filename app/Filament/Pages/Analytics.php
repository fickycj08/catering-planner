<?php

namespace App\Filament\Pages;

use App\Models\Customer;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Pages\Page;

class Analytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Analytics';
    protected static ?string $navigationGroup = 'Reports';

    protected static string $view = 'filament.pages.analytics';

    public array $monthlyData = [];
    public int $revenue = 0;
    public int $orders = 0;
    public int $customers = 0;

    public function mount(): void
    {
        $this->aggregateData();
    }

    protected function aggregateData(): void
    {
        $this->revenue = Order::where('status', 'completed')->sum('total_price');
        $this->orders = Order::count();
        $this->customers = Customer::count();

        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = [
                'month' => $date->format('M Y'),
                'revenue' => Order::where('status', 'completed')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('total_price'),
                'orders' => Order::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'customers' => Customer::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        $this->monthlyData = $data;
    }

    protected function getActions(): array
    {
        return [
            Action::make('exportExcel')
                ->label('Export Excel')
                ->action('exportExcel')
                ->color('success'),
            Action::make('exportPdf')
                ->label('Export PDF')
                ->action('exportPdf')
                ->color('primary'),
        ];
    }

    public function exportExcel()
    {
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Month', 'Revenue', 'Orders', 'New Customers']);
        foreach ($this->monthlyData as $row) {
            fputcsv($handle, [
                $row['month'],
                $row['revenue'],
                $row['orders'],
                $row['customers'],
            ]);
        }
        rewind($handle);

        return response()->streamDownload(function () use ($handle) {
            fpassthru($handle);
        }, 'analytics.csv');
    }

    public function exportPdf()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.analytics', [
            'monthlyData' => $this->monthlyData,
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'analytics.pdf'
        );
    }

}
