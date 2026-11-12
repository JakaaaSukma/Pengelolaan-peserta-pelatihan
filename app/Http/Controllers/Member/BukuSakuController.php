<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\ProgressNote;
use App\Models\TrainingAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BukuSakuController extends Controller
{
    public function index(): View
    {
        $user = Auth::user()->load('profile');

        // Training attendances with training & trainer
        $attendances = TrainingAttendance::with(['training.trainer'])
            ->where('member_id', $user->id)
            ->join('trainings', 'training_attendances.training_id', '=', 'trainings.id')
            ->orderBy('trainings.tanggal', 'desc')
            ->select('training_attendances.*')
            ->get();

        // Interviews with confirmation
        $interviews = Interview::with('confirmation')
            ->where('member_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        // Progress notes by trainers
        $progressNotes = ProgressNote::with('trainer')
            ->where('member_id', $user->id)
            ->latest()
            ->get();

        // Calculate statistics
        $totalTrainingsAttended = $attendances->where('status_kehadiran', 'hadir')->count();
        $totalInterviews = $interviews->count();
        $passedInterviews = $interviews->where('hasil', 'lolos')->count();
        $averageScore = $attendances->whereNotNull('nilai')->avg('nilai');

        // Badges calculation
        $badges = [
            [
                'title' => 'Profil Terverifikasi',
                'desc' => 'Telah melengkapi data pencari kerja secara akurat',
                'icon' => 'verified_user',
                'unlocked' => (bool) $user->profile?->is_profile_complete,
                'color' => 'from-emerald-500/20 to-teal-500/20 border-emerald-500/30 text-emerald-400',
            ],
            [
                'title' => 'Dedikasi Pelatihan',
                'desc' => 'Menghadiri minimal 1 modul pelatihan teknis',
                'icon' => 'military_tech',
                'unlocked' => $totalTrainingsAttended >= 1,
                'color' => 'from-blue-500/20 to-cyan-500/20 border-blue-500/30 text-blue-400',
            ],
            [
                'title' => 'Kompetensi Unggul',
                'desc' => 'Rata-rata nilai evaluasi teknis di atas 85',
                'icon' => 'workspace_premium',
                'unlocked' => $averageScore >= 85,
                'color' => 'from-amber-500/20 to-orange-500/20 border-amber-500/30 text-amber-400',
            ],
            [
                'title' => 'Kandidat Siap Kerja',
                'desc' => 'Memiliki jadwal wawancara aktif dengan mitra industri',
                'icon' => 'stars',
                'unlocked' => $totalInterviews >= 1,
                'color' => 'from-purple-500/20 to-indigo-500/20 border-purple-500/30 text-purple-400',
            ],
        ];

        return view('member.buku-saku', compact(
            'user',
            'attendances',
            'interviews',
            'progressNotes',
            'totalTrainingsAttended',
            'totalInterviews',
            'passedInterviews',
            'averageScore',
            'badges'
        ));
    }
}

