<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Training;
use App\Models\TrainingAttendance;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TrainingController extends Controller
{
    public function index(): View
    {
        $trainings = Training::with(['trainer', 'attendances.member'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(10);

        return view('trainer.trainings.index', compact('trainings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'materi' => ['required', 'string'],
            'tipe' => ['required', 'in:offline,online'],
            'tanggal' => ['required', 'date'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required'],
            'lokasi' => ['nullable', 'string', 'max:200'],
            'link_meeting' => ['nullable', 'url', 'max:255'],
            'platform' => ['nullable', 'string', 'max:100'],
        ], [
            'judul.required' => 'Judul pelatihan wajib diisi.',
            'materi.required' => 'Materi pelatihan wajib diisi.',
            'tipe.required' => 'Tipe pelatihan wajib dipilih.',
            'tanggal.required' => 'Tanggal pelaksanaan wajib diisi.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
        ]);

        $validated['trainer_id'] = Auth::id();
        $training = Training::create($validated);

        // Auto enroll active members
        $members = User::where('role', 'member')
            ->whereHas('profile', function ($q) {
                $q->whereIn('tahap_saat_ini', ['pelatihan', 'evaluasi', 'interview', 'penempatan_kerja']);
            })
            ->get();

        foreach ($members as $member) {
            TrainingAttendance::firstOrCreate([
                'training_id' => $training->id,
                'member_id' => $member->id,
            ], [
                'status_kehadiran' => 'belum_mulai',
            ]);

            Notification::create([
                'user_id' => $member->id,
                'judul' => 'Jadwal Pelatihan Baru',
                'pesan' => 'Pelatihan baru telah ditambahkan: ' . $training->judul . ' pada tanggal ' . $training->tanggal->format('d M Y'),
                'is_read' => false,
            ]);
        }

        return redirect()->route('trainer.trainings.index')
            ->with('success', 'Jadwal pelatihan berhasil ditambahkan dan dibagikan ke peserta.');
    }

    public function show(Training $training): View
    {
        $training->load(['trainer', 'attendances.member.profile']);
        $members = User::where('role', 'member')->with('profile')->get();

        return view('trainer.trainings.show', compact('training', 'members'));
    }

    public function update(Request $request, Training $training): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'materi' => ['required', 'string'],
            'tipe' => ['required', 'in:offline,online'],
            'tanggal' => ['required', 'date'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required'],
            'lokasi' => ['nullable', 'string', 'max:200'],
            'link_meeting' => ['nullable', 'url', 'max:255'],
            'platform' => ['nullable', 'string', 'max:100'],
        ]);

        $training->update($validated);

        return redirect()->route('trainer.trainings.index')
            ->with('success', 'Data pelatihan berhasil diperbarui.');
    }

    public function destroy(Training $training): RedirectResponse
    {
        $training->delete();

        return redirect()->route('trainer.trainings.index')
            ->with('success', 'Jadwal pelatihan berhasil dihapus.');
    }

    public function updateAttendance(Request $request, Training $training): RedirectResponse
    {
        $attendancesData = $request->input('attendances', []);

        foreach ($attendancesData as $attendanceId => $data) {
            $attendance = TrainingAttendance::where('training_id', $training->id)
                ->where('id', $attendanceId)
                ->first();

            if ($attendance) {
                $attendance->update([
                    'status_kehadiran' => $data['status_kehadiran'] ?? 'belum_mulai',
                    'nilai' => !empty($data['nilai']) ? (int) $data['nilai'] : null,
                    'catatan' => $data['catatan'] ?? null,
                ]);
            }
        }

        return back()->with('success', 'Absensi dan nilai peserta berhasil diperbarui.');
    }
}

