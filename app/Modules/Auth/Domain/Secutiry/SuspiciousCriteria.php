<?php

namespace App\Modules\Auth\Domain\Secutiry;

class SuspiciousCriteria
{
    public const NEW_IP = 'new_ip';
    public const NEW_PLATFORM = 'new_platform';
    public const TOO_MANY_SESSIONS = 'too_many_sessions';
}
