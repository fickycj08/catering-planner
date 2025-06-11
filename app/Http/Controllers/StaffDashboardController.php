<?php

// app/Http/Controllers/StaffDashboardController.php

namespace App\Http\Controllers;

use App\Models\OrderStaff;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (! $user->staff) {
            abort(403, 'Akun Anda belum terhubung dengan data staff.');
        }

        $staff = $user->staff;

        // Ambil semua order yang ditugaskan ke staff ini
        $assignedOrders = OrderStaff::with('order')
            ->where('staff_id', $staff->id)
            ->get();

        return view('staff.dashboard', compact('assignedOrders'));
    }

    public function schedule()
    {
        $user = auth()->user();
        if (!$user->staff) {
            abort(403, 'Akun Anda belum terhubung dengan data staff.');
        }

        $assignedOrders = OrderStaff::with('order')
            ->where('staff_id', $user->staff->id)
            ->get();

        $events = $assignedOrders->map(fn($a) => [
            'title' => 'Order #' . $a->order->id,
            'start' => $a->order->scheduled_date->format('Y-m-d'),
            'extendedProps' => [
                'status' => $a->order->status,
                'tujuan' => $a->order->tujuan,
            ],
        ]);

        return view('staff.jadwal', compact('events'));
    }
}
