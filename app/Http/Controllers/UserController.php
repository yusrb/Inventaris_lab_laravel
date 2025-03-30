<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Daftar User';
    
        $query = User::query();
    
        if ($request->has('user_search')) {
            $search = $request->input('user_search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'LIKE', "%$search%")
                  ->orWhere('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
            });
        }
    
        $all_user = $query->paginate(10);
    
        return view('admin.users.index', [
            'settings' => $settings,
            'users' => $all_user,
            'page' => $page,
            'search' => $request->input('search_user')
        ]);
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Create User';
        $context = [
            'settings' => $settings,
            'page' => $page,
        ];
        return view('admin.users.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:40'],
            'username' => ['required', 'max:30'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'name.required' => 'Nama Harus Diisi!',
            'name.max' => 'Maksimal kata Nama 40 karakter!',
            'username.required' => 'Username Harus Diisi!',
            'username.max' => 'Maksimal kata Username 30 karakter!',
            'email.required' => 'Email Harus Diisi!',
            'password.required' => 'Password Harus Diisi!',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'User Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $settings = Settings::where('id', 1)->first();
        $get_user = User::findOrFail($id);
        $page = 'Update User';

        $context = [
            'settings' => $settings,
            'user' => $get_user,
            'page' => $page,
        ];

        return view('admin.users.edit', $context);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:40'],
            'username' => ['required', 'max:30'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'min:6'],
        ], [
            'name.required' => 'Nama Harus Diisi!',
            'name.max' => 'Maksimal kata Nama 40 karakter!',
            'username.required' => 'Username Harus Diisi!',
            'username.max' => 'Maksimal kata Username 30 karakter!',
            'email.required' => 'Email Harus Diisi!',
            'password.required' => 'Password Harus Diisi!',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('update', 'User Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);

        return redirect()->route('user.index')->with('delete', 'User berhasil Di Delete!');
    }
}
