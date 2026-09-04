<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() { return view('admin.users.index', ['users' => User::orderByDesc('created_at')->paginate(20)]); }
    public function create() { return view('admin.users.form'); }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id'  => 'required|exists:roles,id',
        ]);
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user) { return view('admin.users.form', compact('user')); }

    public function update(Request $request, User $user)
    {
        $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email,'.$user->id]);
        $data = $request->only('name', 'email', 'role_id');
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->filled('password')) $data['password'] = Hash::make($request->password);
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) return back()->withErrors(['error' => 'Tidak dapat menghapus akun sendiri.']);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function show(User $user) { return view('admin.users.show', compact('user')); }
}
