<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->isDosen()) {
                return redirect()->intended('/dosen/dashboard');
            } else {
                return redirect()->intended('/mahasiswa/dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
        ]);

            // Create profile based on role
            if ($validated['role'] === 'mahasiswa') {
        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => 'REG' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
            'nama_lengkap' => $user->name,
            'tempat_lahir' => '-',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => 'L',
            'alamat' => '-',
            'no_hp' => '-',
            'program_studi' => '-',
            'angkatan' => now()->year,
            'status' => 'aktif',
        ]);
            } elseif ($validated['role'] === 'dosen') {
                Dosen::create([
                    'user_id' => $user->id,
                    'nip' => 'DOS' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                    'nama_lengkap' => $user->name,
                    'tempat_lahir' => '-',
                    'tanggal_lahir' => now(),
                    'jenis_kelamin' => 'L',
                    'alamat' => '-',
                    'no_hp' => '-',
                    'bidang_keahlian' => '-',
                    'status' => 'aktif',
                ]);
            }
            // Admin doesn't need additional profile

        Auth::login($user);
            
            // Regenerate session
            $request->session()->regenerate();
            
            // Redirect based on role
            if (Auth::check()) {
                switch ($validated['role']) {
                    case 'admin':
                        return redirect('/admin/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Sistem Akademik.');
                    case 'dosen':
                        return redirect('/dosen/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Sistem Akademik.');
                    case 'mahasiswa':
                        return redirect('/mahasiswa/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Sistem Akademik.');
                    default:
                        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login dengan username dan password Anda.');
                }
            } else {
                return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login dengan username dan password Anda.');
            }
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
