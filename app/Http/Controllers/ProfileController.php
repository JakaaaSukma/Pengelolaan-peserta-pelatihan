<?php

namespace App\Http\Controllers;

use App\Models\MemberProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page.
     */
    public function edit(): View
    {
        $user = Auth::user()->load('profile', 'latestPlacement');

        return view('profile.edit', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    /**
     * Update account info & profile details.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];

        if ($user->isMember()) {
            $rules = array_merge($rules, [
                'nik' => ['nullable', 'string', 'max:20'],
                'tempat_lahir' => ['nullable', 'string', 'max:100'],
                'tanggal_lahir' => ['nullable', 'date'],
                'jenis_kelamin' => ['nullable', 'in:L,P'],
                'status_pernikahan' => ['nullable', 'string', 'max:50'],
                'alamat' => ['nullable', 'string'],
                'no_hp' => ['nullable', 'string', 'max:25'],
                'pendidikan_terakhir' => ['nullable', 'string', 'max:100'],
                'jurusan' => ['nullable', 'string', 'max:100'],
                'pengalaman_kerja' => ['nullable', 'string'],
                'skill' => ['nullable', 'string'],
                'sertifikat' => ['nullable', 'string'],
                'bidang_minat' => ['nullable', 'string', 'max:150'],
                'lokasi_minat' => ['nullable', 'string', 'max:150'],
                'ekspektasi_gaji' => ['nullable', 'string', 'max:100'],
                'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            ]);
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'cv.mimes' => 'File CV harus berupa dokumen PDF.',
            'cv.max' => 'Ukuran CV maksimal 5MB.',
        ]);

        // Update User basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        // Update Member Profile if member
        if ($user->isMember()) {
            $profile = MemberProfile::firstOrNew(['user_id' => $user->id]);

            if ($request->hasFile('foto')) {
                if ($profile->foto) {
                    Storage::disk('public')->delete($profile->foto);
                }
                $profile->foto = $request->file('foto')->store('avatars', 'public');
            }

            if ($request->hasFile('cv')) {
                if ($profile->cv_path) {
                    Storage::disk('public')->delete($profile->cv_path);
                }
                $profile->cv_path = $request->file('cv')->store('cv_files', 'public');
            }

            $profile->fill([
                'nik' => $validated['nik'] ?? $profile->nik,
                'tempat_lahir' => $validated['tempat_lahir'] ?? $profile->tempat_lahir,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? $profile->tanggal_lahir,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? $profile->jenis_kelamin,
                'status_pernikahan' => $validated['status_pernikahan'] ?? $profile->status_pernikahan,
                'alamat' => $validated['alamat'] ?? $profile->alamat,
                'no_hp' => $validated['no_hp'] ?? $profile->no_hp,
                'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? $profile->pendidikan_terakhir,
                'jurusan' => $validated['jurusan'] ?? $profile->jurusan,
                'pengalaman_kerja' => $validated['pengalaman_kerja'] ?? $profile->pengalaman_kerja,
                'skill' => $validated['skill'] ?? $profile->skill,
                'sertifikat' => $validated['sertifikat'] ?? $profile->sertifikat,
                'bidang_minat' => $validated['bidang_minat'] ?? $profile->bidang_minat,
                'lokasi_minat' => $validated['lokasi_minat'] ?? $profile->lokasi_minat,
                'ekspektasi_gaji' => $validated['ekspektasi_gaji'] ?? $profile->ekspektasi_gaji,
            ]);

            $profile->save();
        }

        return back()->with('success', 'Profil akun berhasil diperbarui!');
    }
}

