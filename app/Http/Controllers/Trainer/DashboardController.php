<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\MemberProfile;
use App\Models\Placement;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMembers = User::where('role', 'member')->count();

        $activeMembers = MemberProfile::where('is_profile_complete', true)->count();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $interviewsThisWeek = Interview::whereBetween('tanggal', [$startOfWeek, $endOfWeek])->count();

        $placedMembersCount = Placement::where('status', 'ditempatkan')->distinct('member_id')->count();
        $unplacedMembersCount = max(0, $totalMembers - $placedMembersCount);

        // Stages distribution count
        $stagesDistribution = [
            'pendaftaran' => MemberProfile::where('tahap_saat_ini', 'pendaftaran')->count(),
            'melengkapi_data' => MemberProfile::where('tahap_saat_ini', 'melengkapi_data')->count(),
            'pelatihan' => MemberProfile::where('tahap_saat_ini', 'pelatihan')->count(),
            'evaluasi' => MemberProfile::where('tahap_saat_ini', 'evaluasi')->count(),
            'interview' => MemberProfile::where('tahap_saat_ini', 'interview')->count(),
            'penempatan_kerja' => MemberProfile::where('tahap_saat_ini', 'penempatan_kerja')->count(),
        ];

        // Recent registered members
        $recentMembers = User::where('role', 'member')
            ->with(['profile', 'latestPlacement'])
            ->latest()
            ->take(6)
            ->get();

        // Upcoming trainings
        $upcomingTrainings = Training::with('trainer')
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->take(3)
            ->get();

        // Upcoming interviews
        $upcomingInterviews = Interview::with(['member.profile', 'confirmation'])
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->take(5)
            ->get();

        return view('trainer.dashboard', compact(
            'totalMembers',
            'activeMembers',
            'interviewsThisWeek',
            'placedMembersCount',
            'unplacedMembersCount',
            'stagesDistribution',
            'recentMembers',
            'upcomingTrainings',
            'upcomingInterviews'
        ));
    }
}

