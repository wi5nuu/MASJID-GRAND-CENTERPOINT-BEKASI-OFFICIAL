<?php

namespace App\Http\Controllers\Jamaah;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('jamaah.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'required|string|max:20',
            'unit_no'  => 'required|string|max:10|unique:users,unit_no',
            'building' => 'required|in:C,D',
            'floor'    => 'required|string|size:2',
            'unit'     => 'required|string|size:2',
            'password' => 'required|string|min:6|max:128|confirmed',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'unit_no'     => $request->unit_no,
            'password'    => Hash::make($request->password),
            'role_id'     => 4, // jamaah
            'is_active'   => true,
            'approved_at' => null,
        ]);

        return redirect()->route('jamaah.login')->with('success', 'Pendaftaran berhasil. Akun Anda akan aktif setelah disetujui pengurus.');
    }

    private function redirectByRole()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('jamaah.dashboard');
    }
}
