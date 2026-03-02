<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('back.users.index', compact('users'));
    }

    public function create()
    {
        return view('back.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role_id'  => 'required|in:1,2',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role_id'  => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('back.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|in:1,2',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Jangan hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Admin masuk sebagai user lain (impersonation).
     */
    public function loginAs(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat login sebagai diri sendiri.');
        }

        // Simpan ID admin asli di session
        session(['impersonator_id' => auth()->id()]);

        Auth::loginUsingId($user->id);

        // Arahkan ke dashboard sesuai role target
        $dashboard = (int) $user->role_id === 1 ? 'admin.dashboard' : 'gudang.dashboard';
        return redirect()->route($dashboard)->with('info', 'Anda sekarang login sebagai ' . $user->name . '.');
    }

    /**
     * Kembali ke akun admin asal setelah impersonation.
     */
    public function leaveImpersonation()
    {
        $adminId = session('impersonator_id');

        if (! $adminId) {
            return redirect()->route('admin.dashboard');
        }

        session()->forget('impersonator_id');
        Auth::loginUsingId($adminId);

        return redirect()->route('users.index')->with('success', 'Anda telah kembali ke akun admin.');
    }
}
