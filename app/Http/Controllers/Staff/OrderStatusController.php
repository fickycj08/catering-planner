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
        $validStatuses = [
            'Pending' => 'Pending',
            'Processing' => 'Processing',
            'Completed' => 'Completed',
            'Cancelled' => 'Cancelled',
            'pending' => 'Pending',
            'in progress' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $request->validate([
            'status' => ['required', Rule::in(array_keys($validStatuses))],
        ]);

        // 3. Update status order
        $order->status = $validStatuses[$request->status];
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
