<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class KasirAkunController extends Controller
{
    public function index()
    {
        $kasir = User::where('role', 'kasir')
            ->withCount('transaksi')
            ->orderBy('name')
            ->get();

        return view('akun-kasir.index', compact('kasir'));
    }

    public function create()
    {
        return view('akun-kasir.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'kasir',
            'aktif' => true,
        ]);

        return redirect()->route('akun-kasir.index')->with('success', 'Akun kasir berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->ensureKasir($user);

        return view('akun-kasir.edit', ['kasir' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $this->ensureKasir($user);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'aktif' => 'required|boolean',
        ]);

        $user->update($data);

        return redirect()->route('akun-kasir.index')->with('success', 'Data kasir berhasil diperbarui.');
    }

    public function showResetPassword(User $user)
    {
        $this->ensureKasir($user);

        return view('akun-kasir.reset-password', ['kasir' => $user]);
    }

    public function resetPassword(Request $request, User $user)
    {
        $this->ensureKasir($user);

        $data = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => $data['password'],
        ]);

        return redirect()->route('akun-kasir.index')->with('success', "Password {$user->name} berhasil direset.");
    }

    public function destroy(User $user)
    {
        $this->ensureKasir($user);

        if ($user->transaksi()->exists()) {
            return back()->with('error', 'Akun tidak dapat dihapus karena masih memiliki riwayat transaksi. Nonaktifkan akun sebagai gantinya.');
        }

        $user->delete();

        return redirect()->route('akun-kasir.index')->with('success', 'Akun kasir berhasil dihapus.');
    }

    private function ensureKasir(User $user): void
    {
        abort_unless($user->role === 'kasir', 404);
    }
}
