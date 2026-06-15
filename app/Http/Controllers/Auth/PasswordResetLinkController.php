<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }

    /**
     * Reset password using the recovery key from .env.
     */
    public function resetWithKey(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'recovery_key' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $envKey = config('auth.recovery_key');

        if (empty($envKey)) {
            return back()->withErrors(['recovery_key' => 'Fitur kunci pemulihan belum diaktifkan di server.']);
        }

        if ($request->input('recovery_key') !== $envKey) {
            return back()->withErrors(['recovery_key' => 'Kunci pemulihan salah. Silakan cek file .env Anda.']);
        }

        $user = \App\Models\User::where('email', $request->input('email'))->first();
        if ($user) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->input('password'));
            $user->save();
            return redirect()->route('login')->with('success', 'Password berhasil direset menggunakan kunci pemulihan. Silakan login.');
        }

        return back()->withErrors(['email' => 'User tidak ditemukan.']);
    }
}
