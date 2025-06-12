<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuppliersExport implements FromCollection, WithHeadings
{
    protected Collection $suppliers;

    public function __construct(Collection $suppliers)
    {
        $this->suppliers = $suppliers;
    }

    public function collection()
    {
        return $this->suppliers->map(function ($supplier) {
            return [
                'ID' => $supplier->id,
                'Name' => $supplier->name,
                'Contact' => $supplier->contact,
                'Address' => $supplier->address,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Contact', 'Address'];
    }
}
