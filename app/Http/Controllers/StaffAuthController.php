<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StaffAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('staff.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(array_merge($credentials, ['role' => 'staff']))) {
            $request->session()->regenerate();
            return redirect()->intended('/staff/dashboard'); // ubah sesuai route dashboard staff
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau bukan akun staff.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/staff/login');
    }
    public function showRegisterForm()
{
    return view('staff.register');
}

public function register(Request $request)
{

   
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'phone' => 'required|string|max:20',
        'position' => 'required|string|max:255',
    ]);

    try {
        // 1. Buat akun user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        // 2. Buat data staff
        $staff = Staff::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'position' => $request->position,
            'user_id' => $user->id,
        ]);

        // 3. Login langsung
        Auth::login($user);

        return redirect('/staff/dashboard');

    } catch (\Exception $e) {
        // Kalau ada error, tampilkan detailnya
        dd($e->getMessage());
    }

    // 1. Buat akun user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'staff',
    ]);

    // 2. Buat data staff
    Staff::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'position' => $request->position,
        'user_id' => $user->id,
    ]);
    Log::info('Registering staff', $request->all());
    Log::info('User created', ['id' => $user->id]);
Log::info('Staff created', ['id' => $staff->id]);

    // 3. Login langsung
    Auth::login($user);

    return redirect('/staff/dashboard');

    
}
}
