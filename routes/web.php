<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Member\BukuSakuController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\JadwalInterviewController;
use App\Http\Controllers\Member\JadwalPelatihanController;
use App\Http\Controllers\Member\ModuleController as MemberModuleController;
use App\Http\Controllers\Member\OnboardingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboardController;
use App\Http\Controllers\Trainer\InterviewController as TrainerInterviewController;
use App\Http\Controllers\Trainer\MemberController as TrainerMemberController;
use App\Http\Controllers\Trainer\ModuleController as TrainerModuleController;
use App\Http\Controllers\Trainer\TrainingController as TrainerTrainingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Monitoring Member Pelatihan Kerja
|--------------------------------------------------------------------------
*/

// Root redirect
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isTrainer()
            ? redirect()->route('trainer.dashboard')
            : redirect()->route('member.dashboard');
    }
    return redirect()->route('login');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Universal Profile Redirect
Route::middleware('auth')->get('/profile', function () {
    return Auth::user()->isTrainer()
        ? redirect()->route('trainer.profile')
        : redirect()->route('member.profile');
})->name('profile');

// Universal Module Redirect
Route::middleware('auth')->get('/modul', function () {
    return Auth::user()->isTrainer()
        ? redirect()->route('trainer.modules.index')
        : redirect()->route('member.modules.index');
})->name('modules');

// Member Routes
Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    // Onboarding (Form data pencari kerja)
    Route::get('/onboarding', [OnboardingController::class, 'create'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // Dashboard
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

    // Modul Pelatihan (PPT / PDF)
    Route::get('/modul', [MemberModuleController::class, 'index'])->name('modules.index');
    Route::get('/modul/{id}/preview', [MemberModuleController::class, 'preview'])->name('modules.preview');
    Route::get('/modul/{id}/download', [MemberModuleController::class, 'download'])->name('modules.download');

    // Buku Saku Digital
    Route::get('/buku-saku', [BukuSakuController::class, 'index'])->name('buku-saku');

    // Jadwal Pelatihan
    Route::get('/jadwal-pelatihan', [JadwalPelatihanController::class, 'index'])->name('jadwal-pelatihan');

    // Jadwal Interview & Konfirmasi Kehadiran
    Route::get('/jadwal-interview', [JadwalInterviewController::class, 'index'])->name('jadwal-interview');
    Route::post('/jadwal-interview/{interview}/confirm', [JadwalInterviewController::class, 'confirm'])->name('jadwal-interview.confirm');

    // Profil Akun Member
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Trainer Routes
Route::middleware(['auth', 'role:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');

    // Modul Pelatihan (CRUD PPT / PDF)
    Route::get('/modul', [TrainerModuleController::class, 'index'])->name('modules.index');
    Route::post('/modul', [TrainerModuleController::class, 'store'])->name('modules.store');
    Route::get('/modul/{id}/preview', [TrainerModuleController::class, 'preview'])->name('modules.preview');
    Route::delete('/modul/{id}', [TrainerModuleController::class, 'destroy'])->name('modules.destroy');
    Route::get('/modul/{id}/download', [TrainerModuleController::class, 'download'])->name('modules.download');

    // Daftar & Detail Member
    Route::get('/members', [TrainerMemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member}', [TrainerMemberController::class, 'show'])->name('members.show');
    Route::post('/members/{member}/stage', [TrainerMemberController::class, 'updateStage'])->name('members.update-stage');
    Route::post('/members/{member}/note', [TrainerMemberController::class, 'addNote'])->name('members.add-note');
    Route::post('/members/{member}/placement', [TrainerMemberController::class, 'updatePlacement'])->name('members.update-placement');

    // Kelola Pelatihan
    Route::resource('trainings', TrainerTrainingController::class);
    Route::post('trainings/{training}/attendance', [TrainerTrainingController::class, 'updateAttendance'])->name('trainings.update-attendance');

    // Kelola Interview
    Route::resource('interviews', TrainerInterviewController::class);
    Route::post('interviews/{interview}/result', [TrainerInterviewController::class, 'updateResult'])->name('interviews.update-result');

    // Profil Akun Trainer
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
