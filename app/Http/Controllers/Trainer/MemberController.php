<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\MemberProfile;
use App\Models\Notification;
use App\Models\Placement;
use App\Models\ProgressNote;
use App\Models\TrainingAttendance;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');
        $tahap = $request->query('tahap');

        $query = User::where('role', 'member')
            ->with(['profile', 'latestPlacement'])
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function ($p) use ($search) {
                      $p->where('jurusan', 'like', "%{$search}%")
                        ->orWhere('skill', 'like', "%{$search}%")
                        ->orWhere('pendidikan_terakhir', 'like', "%{$search}%");
                  });
            });
        }

        if ($tahap && in_array($tahap, array_keys(MemberProfile::stageList()))) {
            $query->whereHas('profile', function ($p) use ($tahap) {
                $p->where('tahap_saat_ini', $tahap);
            });
        }

        $members = $query->paginate(10)->withQueryString();
        $stages = MemberProfile::stageList();

        return view('trainer.members.index', compact('members', 'search', 'tahap', 'stages'));
    }

    public function show(User $member): View
    {
        if (! $member->isMember()) {
            abort(404);
        }

        $member->load([
            'profile',
            'latestPlacement',
            'placements',
            'attendances.training.trainer',
            'interviews.confirmation',
            'progressNotesAsMember.trainer',
        ]);

        $stages = MemberProfile::stageList();
        $timelineStages = $member->profile ? $member->profile->stage_details : [];

        return view('trainer.members.show', compact('member', 'stages', 'timelineStages'));
    }

    public function updateStage(Request $request, User $member): RedirectResponse
    {
        $validated = $request->validate([
            'tahap' => ['required', 'in:pendaftaran,melengkapi_data,pelatihan,evaluasi,interview,penempatan_kerja'],
        ]);

        $profile = MemberProfile::firstOrOrCreate(['user_id' => $member->id]);
        $profile->tahap_saat_ini = $validated['tahap'];
        $profile->save();

        $stageLabels = [
            'pendaftaran' => 'Pendaftaran',
            'melengkapi_data' => 'Melengkapi Data',
            'pelatihan' => 'Pelatihan Vokasi',
            'evaluasi' => 'Evaluasi Kompetensi',
            'interview' => 'Interview Mitra Industri',
            'penempatan_kerja' => 'Penempatan Kerja Resmi',
        ];

        Notification::create([
            'user_id' => $member->id,
            'judul' => 'Perubahan Tahap Perjalanan',
            'pesan' => 'Selamat! Trainer telah memperbarui tahap perjalanan Anda menjadi: ' . ($stageLabels[$validated['tahap']] ?? $validated['tahap']),
            'is_read' => false,
        ]);

        return back()->with('success', 'Tahap perjalanan member ' . $member->name . ' berhasil diperbarui.');
    }

    public function addNote(Request $request, User $member): RedirectResponse
    {
        $validated = $request->validate([
            'catatan' => ['required', 'string', 'max:1000'],
        ], [
            'catatan.required' => 'Catatan perkembangan tidak boleh kosong.',
        ]);

        ProgressNote::create([
            'member_id' => $member->id,
            'trainer_id' => Auth::id(),
            'catatan' => $validated['catatan'],
        ]);

        Notification::create([
            'user_id' => $member->id,
            'judul' => 'Catatan Perkembangan Baru',
            'pesan' => Auth::user()->name . ' menambahkan catatan perkembangan pada Buku Saku Anda.',
            'is_read' => false,
        ]);

        return back()->with('success', 'Catatan perkembangan berhasil ditambahkan.');
    }

    public function updatePlacement(Request $request, User $member): RedirectResponse
    {
        $validated = $request->validate([
            'perusahaan' => ['required', 'string', 'max:150'],
            'posisi' => ['required', 'string', 'max:150'],
            'tanggal_mulai' => ['nullable', 'date'],
            'status' => ['required', 'in:proses,ditempatkan,selesai,batal'],
        ], [
            'perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'posisi.required' => 'Posisi pekerjaan wajib diisi.',
            'status.required' => 'Status penempatan wajib dipilih.',
        ]);

        $placement = Placement::firstOrNew(['member_id' => $member->id]);
        $placement->fill($validated);
        $placement->save();

        if ($validated['status'] === 'ditempatkan') {
            $profile = MemberProfile::firstOrOrCreate(['user_id' => $member->id]);
            $profile->tahap_saat_ini = 'penempatan_kerja';
            $profile->save();
        }

        Notification::create([
            'user_id' => $member->id,
            'judul' => 'Pembaruan Status Penempatan Kerja',
            'pesan' => 'Status penempatan Anda di ' . $validated['perusahaan'] . ' sebagai ' . $validated['posisi'] . ' diperbarui menjadi: ' . strtoupper($validated['status']),
            'is_read' => false,
        ]);

        return back()->with('success', 'Data penempatan kerja berhasil disimpan.');
    }
}

