<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalPelatihanController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $filter = $request->query('tipe', 'all');

        $query = Training::with(['trainer', 'modules', 'attendances' => function ($q) use ($user) {
            $q->where('member_id', $user->id);
        }]);

        if (in_array($filter, ['offline', 'online'])) {
            $query->where('tipe', $filter);
        }

        $trainings = $query->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $upcomingCount = $trainings->where('tanggal', '>=', Carbon::today())->count();
        $offlineCount = Training::where('tipe', 'offline')->count();
        $onlineCount = Training::where('tipe', 'online')->count();

        return view('member.jadwal-pelatihan', compact(
            'trainings',
            'filter',
            'upcomingCount',
            'offlineCount',
            'onlineCount'
        ));
    }
}

