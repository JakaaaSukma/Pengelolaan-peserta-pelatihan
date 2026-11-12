<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\InterviewConfirmation;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InterviewController extends Controller
{
    public function index(): View
    {
        $interviews = Interview::with(['member.profile', 'confirmation'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10);

        $members = User::where('role', 'member')
            ->with('profile')
            ->orderBy('name')
            ->get();

        return view('trainer.interviews.index', compact('interviews', 'members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:users,id'],
            'perusahaan' => ['required', 'string', 'max:150'],
            'posisi' => ['required', 'string', 'max:150'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required'],
            'tipe' => ['required', 'in:offline,online'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url', 'max:255'],
        ], [
            'member_id.required' => 'Pilih kandidat member.',
            'perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'posisi.required' => 'Posisi pekerjaan wajib diisi.',
            'tanggal.required' => 'Tanggal wawancara wajib diisi.',
            'jam.required' => 'Jam wawancara wajib diisi.',
        ]);

        $interview = Interview::create($validated);

        // Create default confirmation record
        InterviewConfirmation::create([
            'interview_id' => $interview->id,
            'status' => 'menunggu',
        ]);

        Notification::create([
            'user_id' => $validated['member_id'],
            'judul' => 'Jadwal Interview Baru Masuk',
            'pesan' => 'Anda dijadwalkan wawancara dengan ' . $validated['perusahaan'] . ' untuk posisi ' . $validated['posisi'] . ' pada tanggal ' . $interview->tanggal->format('d M Y') . '. Harap segera konfirmasi kehadiran Anda.',
            'is_read' => false,
        ]);

        return redirect()->route('trainer.interviews.index')
            ->with('success', 'Jadwal interview berhasil dibuat dan diteruskan ke member.');
    }

    public function update(Request $request, Interview $interview): RedirectResponse
    {
        $validated = $request->validate([
            'perusahaan' => ['required', 'string', 'max:150'],
            'posisi' => ['required', 'string', 'max:150'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required'],
            'tipe' => ['required', 'in:offline,online'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url', 'max:255'],
            'hasil' => ['required', 'in:belum_ada,lolos,tidak_lolos,menunggu_hasil'],
            'feedback' => ['nullable', 'string'],
        ]);

        $interview->update($validated);

        return redirect()->route('trainer.interviews.index')
            ->with('success', 'Data interview berhasil diperbarui.');
    }

    public function destroy(Interview $interview): RedirectResponse
    {
        $interview->delete();

        return redirect()->route('trainer.interviews.index')
            ->with('success', 'Jadwal interview berhasil dihapus.');
    }

    public function updateResult(Request $request, Interview $interview): RedirectResponse
    {
        $validated = $request->validate([
            'hasil' => ['required', 'in:belum_ada,lolos,tidak_lolos,menunggu_hasil'],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        $interview->update($validated);

        $labels = [
            'lolos' => 'LOLOS',
            'tidak_lolos' => 'TIDAK LOLOS',
            'menunggu_hasil' => 'MENUNGGU HASIL',
        ];

        Notification::create([
            'user_id' => $interview->member_id,
            'judul' => 'Hasil Interview Dirilis: ' . $interview->perusahaan,
            'pesan' => 'Hasil wawancara Anda di ' . $interview->perusahaan . ' telah diperbarui menjadi: ' . ($labels[$validated['hasil']] ?? $validated['hasil']) . ($validated['feedback'] ? '. Feedback: ' . $validated['feedback'] : ''),
            'is_read' => false,
        ]);

        return back()->with('success', 'Hasil dan feedback interview berhasil disimpan.');
    }
}

