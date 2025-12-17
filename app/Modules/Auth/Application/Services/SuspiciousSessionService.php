<?php

namespace App\Modules\Auth\Application\Services;

use App\Modules\Auth\Domain\Secutiry\SuspiciousCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuspiciousSessionService
{
    public function evaluate(Request $request, array $criteria): void
    {
        if (!$request->hasSession() || !$request->user()) {
            return;
        }

        $user = $request->user();
        $sessionId = $request->session()->getId();
        $reasons = [];

        if (in_array(SuspiciousCriteria::NEW_IP, $criteria)) {
            if (!$this->isKnownIp($user->id, $request->ip())) {
                $reasons[] = 'new_ip_address';
            }
        }

        if (in_array(SuspiciousCriteria::NEW_PLATFORM, $criteria)) {
            if (!$this->isKnownPlatform($user->id, $request)) {
                $reasons[] = 'new_platform';
            }
        }

        if (in_array(SuspiciousCriteria::TOO_MANY_SESSIONS, $criteria)) {
            if ($this->hasTooManySessions($user->id)) {
                $reasons[] = 'too_many_active_sessions';
            }
        }

        if (!empty($reasons)) {
            DB::table('sessions')
                ->where('id', $sessionId)
                ->update([
                    'is_suspicious' => true,
                    'suspicious_reason' => implode(',', $reasons),
                ]);
        }
    }

    protected function isKnownIp(int $userId, string $ip): bool
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->where('ip_address', $ip)
            ->exists();
    }

    protected function isKnownPlatform(int $userId, Request $request): bool
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->where('platform', $request->header('sec-ch-ua-platform'))
            ->exists();
    }

    protected function hasTooManySessions(int $userId): bool
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->whereNull('logged_out_at')
            ->count() > 5;
    }
}
