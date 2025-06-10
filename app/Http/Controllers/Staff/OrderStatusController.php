<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    public function update(Request $request, Order $order)
    {
        // Validasi input status
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
        ]);

        // Pastikan order ini memang ditugaskan ke staff yang login
        $staffId = Auth::user()->staff->id;
        if (! $order->assignments()->where('staff_id', $staffId)->exists()) {
            abort(403, 'Anda tidak berhak mengubah status order ini.');
        }

        // Update status
        $order->status = $data['status'];
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
