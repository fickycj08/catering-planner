<?php

use App\Exports\SuppliersExport;
use App\Models\Supplier;
use Illuminate\Support\Collection;

it('exports suppliers to collection with headings', function () {
    $suppliers = Supplier::factory()->count(2)->create();

    $export = new SuppliersExport($suppliers);

    $rows = $export->collection();

    expect($rows)->toHaveCount(2)
        ->and($rows->first())->toHaveKeys(['ID', 'Name', 'Contact', 'Address']);
});
