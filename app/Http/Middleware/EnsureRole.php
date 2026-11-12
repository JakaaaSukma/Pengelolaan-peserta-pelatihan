<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if ($request->user()->role !== $role) {
            // Redirect to appropriate dashboard according to role
            if ($request->user()->role === 'trainer') {
                return redirect()->route('trainer.dashboard')->with('error', 'Akses dialihkan ke dashboard Trainer.');
            }

            return redirect()->route('member.dashboard')->with('error', 'Akses dialihkan ke dashboard Member.');
        }

        // If member has incomplete profile and is not currently on the onboarding page, redirect to onboarding
        if ($role === 'member' && ! $request->is('member/onboarding*')) {
            $profile = $request->user()->profile;
            if (! $profile || ! $profile->is_profile_complete) {
                return redirect()->route('member.onboarding')->with('info', 'Silakan lengkapi data profil pencari kerja Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}

