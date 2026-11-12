<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\InterviewConfirmation;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalInterviewController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $interviews = Interview::with('confirmation')
            ->where('member_id', $user->id)
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->get();

        $upcomingInterview = $interviews
            ->where('tanggal', '>=', Carbon::today())
            ->first();

        return view('member.jadwal-interview', compact(
            'interviews',
            'upcomingInterview'
        ));
    }

    public function confirm(Request $request, Interview $interview): RedirectResponse
    {
        // Policy / security check: member can only confirm their own interview
        if ($interview->member_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:hadir,tidak_hadir,reschedule'],
            'alasan' => ['required_if:status,tidak_hadir,reschedule', 'nullable', 'string', 'max:500'],
        ], [
            'status.required' => 'Pilihan konfirmasi kehadiran wajib diisi.',
            'alasan.required_if' => 'Alasan wajib diisi jika Anda memilih Tidak Hadir atau Minta Reschedule.',
        ]);

        $confirmation = InterviewConfirmation::firstOrNew(['interview_id' => $interview->id]);
        $confirmation->status = $validated['status'];
        $confirmation->alasan = $validated['alasan'] ?? null;
        $confirmation->confirmed_at = now();
        $confirmation->save();

        // Send notification to trainers
        $trainers = User::where('role', 'trainer')->get();
        $statusLabels = [
            'hadir' => 'HADIR',
            'tidak_hadir' => 'TIDAK HADIR',
            'reschedule' => 'MINTA RESCHEDULE',
        ];
        $statusLabel = $statusLabels[$validated['status']] ?? $validated['status'];

        foreach ($trainers as $trainer) {
            Notification::create([
                'user_id' => $trainer->id,
                'judul' => 'Konfirmasi Interview: ' . Auth::user()->name,
                'pesan' => Auth::user()->name . ' mengonfirmasi [' . $statusLabel . '] untuk interview di ' . $interview->perusahaan . ($validated['alasan'] ? ' (Alasan: ' . $validated['alasan'] . ')' : ''),
                'is_read' => false,
            ]);
        }

        $message = match ($validated['status']) {
            'hadir' => 'Terima kasih, konfirmasi [HADIR] berhasil disimpan. Persiapkan diri Anda sebaik mungkin!',
            'tidak_hadir' => 'Konfirmasi [TIDAK HADIR] telah dicatat. Trainer akan meninjau alasan Anda.',
            'reschedule' => 'Permintaan [RESCHEDULE] berhasil dikirim. Trainer akan berkoordinasi dengan mitra korporat.',
        };

        return redirect()->route('member.jadwal-interview')
            ->with('success', $message);
    }
}

