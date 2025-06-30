<?php

// app/Http/Controllers/StaffDashboardController.php



namespace App\Http\Controllers;

use App\Models\OrderStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // import Hash dari main

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

    public function schedule(Request $request)
    {
        $user = auth()->user();
        if (! $user->staff) {
            abort(403, 'Akun Anda belum terhubung dengan data staff.');
        }

        $assignedOrders = OrderStaff::with('order')
            ->where('staff_id', $user->staff->id)
            ->when($request->status, function ($query) use ($request) {
                $query->whereHas('order', fn ($q) => $q->where('status', $request->status));
            })
            ->when($request->start_date, function ($query) use ($request) {
                $query->whereHas('order', fn ($q) => $q->whereDate('scheduled_date', '>=', $request->start_date));
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->whereHas('order', fn ($q) => $q->whereDate('scheduled_date', '<=', $request->end_date));
            })
            ->get();

        $events = $assignedOrders->map(fn ($a) => [
            'title' => 'Order #' . $a->order->id,
            'start' => $a->order->scheduled_date->format('Y-m-d'),
            'extendedProps' => [
                'status' => $a->order->status,
                'tujuan' => $a->order->tujuan,
                'event_type' => $a->order->event_type,
                'customer' => optional($a->order->customer)->name,
            ],
        ]);

        return view('staff.jadwal', [
            'events' => $events,
            'filters' => $request->only(['status', 'start_date', 'end_date']),
        ]);
    }

    public function showProfile()
    {
        $user = auth()->user();
        if (!$user->staff) {
            abort(403, 'Akun Anda belum terhubung dengan data staff.');
        }

        $staff = $user->staff;

        return view('staff.profile', compact('staff'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        if (!$user->staff) {
            abort(403, 'Akun Anda belum terhubung dengan data staff.');
        }

        $staff = $user->staff;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $staff->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? $staff->phone,
            'position' => $validated['position'] ?? $staff->position,
        ]);

        $user->name = $validated['name'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
