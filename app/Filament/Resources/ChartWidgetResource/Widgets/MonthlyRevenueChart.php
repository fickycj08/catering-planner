<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use App\Models\Order; // Ganti dengan model Anda yang sesuai

class MonthlyRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pendapatan Bulanan';
    
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // --- Di sini Anda harus mengganti dengan logika query data Anda ---
        // Contoh: Mengambil data dari 6 bulan terakhir
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $date = $month->format('Y-m');
            $monthName = $month->format('F Y');

            // Contoh query (HARAP DISESUAIKAN!)
            // Anggaplah Anda punya model Order dengan kolom `created_at` dan `total_price`
            $revenue = Order::whereYear('created_at', $month->year)
                            ->whereMonth('created_at', $month->month)
                            ->sum('total_price'); // Sesuaikan dengan kolom harga Anda

            $data[] = $revenue;
            $labels[] = $monthName;
        }
        // --- Akhir bagian logika query ---

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'tension' => 0.4, // Membuat garis lebih melengkung (smooth)
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe grafik: 'line', 'bar', 'pie', 'doughnut', dll.
    }
}