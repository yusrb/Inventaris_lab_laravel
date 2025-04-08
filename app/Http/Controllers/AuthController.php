<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login_view()
    {
        $settings = Settings::where('id', 1)->first();
        $userAdmin = User::where('role', 'admin')->get();
        $context = [
            'settings' => $settings,
            'usersAdmin' => $userAdmin,
        ];
        return view('auth.login', $context);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'max:30'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username harus diisi!',
            'username.max' => 'Username maksimal 30 karakter!',
            'password.required' => 'Password harus diisi!',
        ]);

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            return redirect()->route('dashboard.index')->with('success', 'Anda Berhasil Login!');
        }

        return back()->withErrors([
            'username' => 'Username dan Password tidak ditemukan dalam record kami!.',
        ])->onlyInput('username');
    }

    public function register_view()
    {
        $settings = Settings::where('id', 1)->first();
        $context = [
            'settings' => $settings
        ];
        return view('auth.register', $context);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:40'],
            'username' => ['required', 'max:20'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'name.required' => 'Nama harus diisi!',
            'name.max' => 'Nama maksimal 40 karakter!',
            'username.required' => 'Username harus diisi!',
            'username.max' => 'Username maksimal 25 karakter!',
            'email.required' => 'Email harus diisi!',
            'password.required' => 'Password harus diisi!',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success','Akun anda berhasil dibuat!.');
    }

    public function logout_success_view()
    {
        $settings = Settings::where('id', 1)->first();
        $title = $settings->name_website;
        $tagline = $settings->tagline;
        $context = [
            'settings' => $settings,
            'title' => $title,
            'tagline' => $tagline,
        ];
        return view('auth.logout-success', $context);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('logout_success.index');
    }
}
