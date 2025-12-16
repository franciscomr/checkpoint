<?php

namespace App\Modules\Auth\Application\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SessionAuditService
{
    public function register(Request $request): void
    {
        $user = Auth::user();

        if (!$user || !$request->hasSession()) {
            return;
        }

        DB::table('sessions')->updateOrInsert(
            ['id' => $request->session()->getId()],
            [
                'user_id' => $user->id,
                'employee_id' => $user->employee_id ?? null,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'platform' => $this->detectPlatform($request->userAgent()),
                'payload' => '',
                'last_activity'=> now()->timestamp,
                'logged_in_at' => now(),
                'logged_out_at' => null,
            ]
        ); 
    }

    public function close(Request $request): void
    {
        if (!$request->hasSession()) {
            return;
        }

        DB::table('sessions')
            ->where('id', $request->session()->getId())
            ->update([
                'last_activity' => now()->timestamp,
                'logged_out_at' => now(),
            ]);

    }

    protected function detectPlatform(?string $userAgent): string
    {
        $ua = strtolower($userAgent ?? '');
        return match (true) {
            str_contains($ua, 'windows') => 'windows',
            str_contains($ua, 'macintosh'), str_contains($ua, 'mac os') => 'mac',
            str_contains($ua, 'linux') => 'linux',
            str_contains($ua, 'android') => 'android',
            str_contains($ua, 'iphone'), str_contains($ua, 'ipad') => 'ios',
            default => 'unknown',
        };
    }
}
