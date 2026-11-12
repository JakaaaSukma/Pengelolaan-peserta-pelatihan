<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $user = Auth::user()->load('profile');

        return view('member.onboarding', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nik' => ['required', 'string', 'max:20'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'status_pernikahan' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:25'],
            'pendidikan_terakhir' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:100'],
            'pengalaman_kerja' => ['nullable', 'string'],
            'skill' => ['required', 'string'],
            'sertifikat' => ['nullable', 'string'],
            'bidang_minat' => ['required', 'string', 'max:150'],
            'lokasi_minat' => ['required', 'string', 'max:150'],
            'ekspektasi_gaji' => ['nullable', 'string', 'max:100'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'alamat.required' => 'Alamat lengkap domisili wajib diisi.',
            'no_hp.required' => 'Nomor HP/WhatsApp aktif wajib diisi.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'jurusan.required' => 'Jurusan pendidikan wajib diisi.',
            'skill.required' => 'Keahlian atau keahlian utama wajib diisi.',
            'bidang_minat.required' => 'Bidang pekerjaan yang diminati wajib diisi.',
            'lokasi_minat.required' => 'Lokasi penempatan kerja yang diminati wajib diisi.',
            'foto.image' => 'File foto profil harus berformat gambar (JPG/PNG/WEBP).',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'cv.mimes' => 'File CV harus berformat PDF.',
            'cv.max' => 'Ukuran file CV maksimal 5MB.',
        ]);

        $profile = MemberProfile::firstOrNew(['user_id' => $user->id]);

        if ($request->hasFile('foto')) {
            if ($profile->foto) {
                Storage::disk('public')->delete($profile->foto);
            }
            $validated['foto'] = $request->file('foto')->store('avatars', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($profile->cv_path) {
                Storage::disk('public')->delete($profile->cv_path);
            }
            $validated['cv_path'] = $request->file('cv')->store('cv_files', 'public');
        }

        $validated['is_profile_complete'] = true;
        // Advance stage to pelatihan if still in pendaftaran / melengkapi_data
        if (in_array($profile->tahap_saat_ini, ['pendaftaran', 'melengkapi_data', null])) {
            $validated['tahap_saat_ini'] = 'pelatihan';
        }

        $profile->fill($validated);
        $profile->save();

        return redirect()->route('member.dashboard')
            ->with('success', 'Data profil pencari kerja Anda berhasil disimpan. Selamat datang di tahap Pelatihan Vokasi!');
    }
}

