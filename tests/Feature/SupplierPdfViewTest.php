<?php

use App\Models\Supplier;

it('renders pdf view with suppliers', function () {
    $suppliers = Supplier::factory()->count(2)->create();

    $html = view('exports.suppliers', ['suppliers' => $suppliers])->render();

    foreach ($suppliers as $supplier) {
        expect($html)->toContain($supplier->name);
    }
});
