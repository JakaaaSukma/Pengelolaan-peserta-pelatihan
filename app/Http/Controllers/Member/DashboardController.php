<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\Notification;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user()->load('profile', 'latestPlacement');
        $profile = $user->profile;

        // Next upcoming training
        $nextTraining = Training::with('trainer')
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->first();

        // Next upcoming interview
        $nextInterview = Interview::with('confirmation')
            ->where('member_id', $user->id)
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->first();

        // Recent Notifications
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Attendance stats
        $totalTrainingsAttended = TrainingAttendance::where('member_id', $user->id)
            ->where('status_kehadiran', 'hadir')
            ->count();

        $totalInterviews = Interview::where('member_id', $user->id)->count();

        $timelineStages = $profile ? $profile->stage_details : [];
        $progressPercentage = $profile ? $profile->progress_percentage : 16;

        return view('member.dashboard', compact(
            'user',
            'profile',
            'nextTraining',
            'nextInterview',
            'notifications',
            'totalTrainingsAttended',
            'totalInterviews',
            'timelineStages',
            'progressPercentage'
        ));
    }
}

