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
        $lines = ['Analytics Summary'];
        foreach ($this->monthlyData as $row) {
            $lines[] = sprintf(
                '%s - Revenue: %s, Orders: %d, Customers: %d',
                $row['month'],
                $row['revenue'],
                $row['orders'],
                $row['customers'],
            );
        }

        $pdf = $this->generatePdf($lines);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="analytics.pdf"',
        ]);
    }

    private function generatePdf(array $lines): string
    {
        $y = 750;
        $content = "BT\n/F1 12 Tf\n";
        foreach ($lines as $line) {
            $content .= "1 0 0 1 50 $y Tm ($line) Tj\n";
            $y -= 16;
        }
        $content .= "ET";
        $len = strlen($content);

        $objects = [];
        $objects[] = "<< /Type /Catalog /Pages 2 0 R >>";
        $objects[] = "<< /Type /Pages /Kids [3 0 R] /Count 1 >>";
        $objects[] = "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>";
        $objects[] = "<< /Length $len >>\nstream\n$content\nendstream";
        $objects[] = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>";

        $pdf = "%PDF-1.4\n";
        $offsets = [];
        $offset = strlen($pdf);
        foreach ($objects as $i => $obj) {
            $offsets[] = $offset;
            $pdf .= ($i + 1) . " 0 obj\n" . $obj . "\nendobj\n";
            $offset = strlen($pdf);
        }

        $xref = "xref\n0 " . (count($objects) + 1) . "\n0000000000 65535 f \n";
        foreach ($offsets as $o) {
            $xref .= sprintf("%010d 00000 n \n", $o);
        }

        $pdf .= $xref;
        $pdf .= "trailer\n<< /Root 1 0 R /Size " . (count($objects) + 1) . " >>\n";
        $pdf .= "startxref\n" . strlen($pdf) . "\n%%EOF";

        return $pdf;
    }
}
