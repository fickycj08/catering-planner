<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderStatusController extends Controller
{
    public function update(Request $request, Order $order)
    {
        // 1. Cek apakah staff login posisi Manager
        $user = auth()->user();
        if (!$user->staff || $user->staff->position !== 'Manager') {
            abort(403, 'Anda tidak punya akses untuk mengubah status pesanan.');
        }

        // 2. Validasi input status
        $request->validate([
            'status' => [
        'required',
        Rule::in(['Pending', 'Processing', 'Completed', 'Cancelled']),
    ],
        ]);

        // 3. Update status order
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
