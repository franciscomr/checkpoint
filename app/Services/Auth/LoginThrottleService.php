<?php

namespace App\Services\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class LoginThrottleService
{
    protected int $basePenalty = 15; // segundos por nivel
    protected int $maxFailedAttempts = 6; 
    protected int $temporaryBanMinutes = 15;

    protected string $keyPrefix = 'login_throttle_';

    public function getKey(string $identifier): string
    {
        // Identificador genérico: email o username
        return $this->keyPrefix . strtolower($identifier);
    }

    public function getState(string $identifier): array
    {
        return Cache::get($this->getKey($identifier), [
            'failed_attempts' => 0,
            'penalty_until' => null,
            'temporarily_banned_until' => null,
        ]);
    }

    public function saveState(string $identifier, array $state): void
    {
        Cache::put($this->getKey($identifier), $state, now()->addMinutes(30));
    }

    public function clearState(string $identifier): void
    {
        Cache::forget($this->getKey($identifier));
    }

    public function registerFailedAttempt(string $identifier): array
    {
        $state = $this->getState($identifier);
        $state['failed_attempts']++;

        // 1) Penalización creciente después del 3er intento
        if ($state['failed_attempts'] >= 3 && $state['failed_attempts'] < $this->maxFailedAttempts) {
            $seconds = ($state['failed_attempts'] - 2) * $this->basePenalty;
            $state['penalty_until'] = Carbon::now()->addSeconds($seconds);
        }

        // 2) Inactivación al 6º intento
        if ($state['failed_attempts'] >= $this->maxFailedAttempts) {
            $state['temporarily_banned_until'] = Carbon::now()->addMinutes($this->temporaryBanMinutes);
        }

        $this->saveState($identifier, $state);
        return $state;
    }

    public function registerSuccess(string $identifier): void
    {
        $this->clearState($identifier);
    }

    public function getRemainingPenalty(string $identifier): int
    {
        $state = $this->getState($identifier);

        // Checar baneo temporal
        if ($state['temporarily_banned_until']) {
            $remaining = Carbon::now()->diffInSeconds(Carbon::parse($state['temporarily_banned_until']), false);
            return max(0, $remaining);
        }

        // Checar penalización progresiva
        if ($state['penalty_until']) {
            $remaining = Carbon::now()->diffInSeconds(Carbon::parse($state['penalty_until']), false);
            return max(0, $remaining);
        }

        return 0;
    }

    public function isBlocked(string $identifier): bool
    {
        return $this->getRemainingPenalty($identifier) > 0;
    }
}
