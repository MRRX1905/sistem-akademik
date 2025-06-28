<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['mahasiswa', 'dosen'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'nim' => 'nullable|string|unique:mahasiswas,nim',
            'nip' => 'nullable|string|unique:dosens,nip',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'program_studi' => 'nullable|string|max:255',
            'angkatan' => 'nullable|integer',
            'bidang_keahlian' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create related data based on role
        if ($validated['role'] === 'mahasiswa') {
            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'nama_lengkap' => $validated['name'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'program_studi' => $validated['program_studi'],
                'angkatan' => $validated['angkatan'],
                'status' => 'aktif',
            ]);
        } elseif ($validated['role'] === 'dosen') {
            Dosen::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'nama_lengkap' => $validated['name'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'bidang_keahlian' => $validated['bidang_keahlian'],
                'pendidikan_terakhir' => $validated['pendidikan_terakhir'],
                'status' => 'aktif',
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'nim' => 'nullable|string|unique:mahasiswas,nim,' . ($user->mahasiswa->id ?? ''),
            'nip' => 'nullable|string|unique:dosens,nip,' . ($user->dosen->id ?? ''),
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'program_studi' => 'nullable|string|max:255',
            'angkatan' => 'nullable|integer',
            'bidang_keahlian' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
        ]);

        // Update user
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Update related data based on role
        if ($validated['role'] === 'mahasiswa') {
            if ($user->mahasiswa) {
                $user->mahasiswa->update([
                    'nim' => $validated['nim'],
                    'nama_lengkap' => $validated['name'],
                    'tempat_lahir' => $validated['tempat_lahir'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'alamat' => $validated['alamat'],
                    'no_hp' => $validated['no_hp'],
                    'program_studi' => $validated['program_studi'],
                    'angkatan' => $validated['angkatan'],
                ]);
            } else {
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $validated['nim'],
                    'nama_lengkap' => $validated['name'],
                    'tempat_lahir' => $validated['tempat_lahir'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'alamat' => $validated['alamat'],
                    'no_hp' => $validated['no_hp'],
                    'program_studi' => $validated['program_studi'],
                    'angkatan' => $validated['angkatan'],
                    'status' => 'aktif',
                ]);
            }
        } elseif ($validated['role'] === 'dosen') {
            if ($user->dosen) {
                $user->dosen->update([
                    'nip' => $validated['nip'],
                    'nama_lengkap' => $validated['name'],
                    'tempat_lahir' => $validated['tempat_lahir'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'alamat' => $validated['alamat'],
                    'no_hp' => $validated['no_hp'],
                    'bidang_keahlian' => $validated['bidang_keahlian'],
                    'pendidikan_terakhir' => $validated['pendidikan_terakhir'],
                ]);
            } else {
                Dosen::create([
                    'user_id' => $user->id,
                    'nip' => $validated['nip'],
                    'nama_lengkap' => $validated['name'],
                    'tempat_lahir' => $validated['tempat_lahir'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'alamat' => $validated['alamat'],
                    'no_hp' => $validated['no_hp'],
                    'bidang_keahlian' => $validated['bidang_keahlian'],
                    'pendidikan_terakhir' => $validated['pendidikan_terakhir'],
                    'status' => 'aktif',
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
} 