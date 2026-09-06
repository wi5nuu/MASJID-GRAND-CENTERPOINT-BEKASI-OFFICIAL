<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::with('role')->orderByDesc('created_at');

        if ($search = trim((string) $request->input('search', ''))) {
            $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('unit_no', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $q->whereHas('role', fn ($r) => $r->where('name', $request->input('role')));
        }

        switch ($request->input('status')) {
            case 'pending':
                $q->whereHas('role', fn ($r) => $r->where('name', 'jamaah'))
                  ->whereNull('approved_at');
                break;
            case 'active':
                $q->where('is_active', true)->where(function ($w) {
                    $w->whereNotNull('approved_at')
                      ->orWhereHas('role', fn ($r) => $r->where('name', '!=', 'jamaah'));
                });
                break;
            case 'inactive':
                $q->where('is_active', false);
                break;
        }

        $users = $q->paginate(20)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => \App\Models\Role::orderBy('id')->get(),
            'selectableIds' => $users->getCollection()->pluck('id')
                ->reject(fn ($id) => (int) $id === (int) auth()->id())->values(),
        ]);
    }
    public function create() { return view('admin.users.form', ['roles' => \App\Models\Role::all()]); }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'role_id'     => 'required|exists:roles,id',
            'unit_no'     => 'nullable|string|max:10|unique:users,unit_no',
            'approved_at' => 'nullable|date',
        ]);
        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role_id'     => $request->role_id,
            'unit_no'     => $request->unit_no,
            'is_active'   => $request->boolean('is_active', true),
            'approved_at' => $request->approved_at ? \Carbon\Carbon::parse($request->approved_at) : now(),
        ]);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function approve(User $user)
    {
        if ($user->approved_at) {
            return back()->with('success', 'User sudah disetujui sebelumnya.');
        }
        if ($user->hasRole('jamaah')) {
            $user->update(['approved_at' => now(), 'is_active' => true]);
            return back()->with('success', 'User jamaah berhasil disetujui.');
        }
        return back()->withErrors(['error' => 'Hanya user jamaah yang memerlukan persetujuan.']);
    }

    public function edit(User $user) { return view('admin.users.form', ['user' => $user, 'roles' => \App\Models\Role::orderBy('id')->get()]); }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,'.$user->id,
            'unit_no'     => 'nullable|string|max:10|unique:users,unit_no,'.$user->id,
            'approved_at' => 'nullable|date',
        ]);
        $data = $request->only('name', 'email', 'role_id', 'unit_no', 'approved_at');
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->filled('password')) $data['password'] = Hash::make($request->password);
        if ($data['approved_at']) $data['approved_at'] = \Carbon\Carbon::parse($data['approved_at']);
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) return back()->withErrors(['error' => 'Tidak dapat menghapus akun sendiri.']);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = collect((array) $request->input('ids', []))
            ->map(fn ($id) => (int) $id)
            ->reject(fn ($id) => $id === (int) auth()->id() || $id <= 0)
            ->unique()
            ->values();
        if ($ids->isEmpty()) {
            return back()->withErrors(['error' => 'Pilih minimal satu pengguna untuk dihapus.']);
        }
        $count = User::whereIn('id', $ids)->delete();
        return back()->with('success', $count . ' pengguna berhasil dihapus.');
    }

    public function show(User $user) { return view('admin.users.show', compact('user')); }
}
